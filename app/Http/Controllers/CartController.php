<?php

namespace App\Http\Controllers;

use App\Helpers\General\EarningHelper;
use App\Mail\OfflineOrderMail;
use App\Models\Bundle;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\BillingModel;
use App\Models\CourseBill;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PHPUnit\Framework\Constraint\Count;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use \Auth;
use App\Models\Transactions;
use App\Models\Auth\User;

class CartController extends Controller
{

    private $path;
    private $currency;

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
        $this->currency = getCurrency(config('app.currency'));


    }

    public function index(Request $request)
    {
        $ids = Cart::session(auth()->user()->id)->getContent()->keys();
        $course_ids = [];
        $bundle_ids = [];
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $course_ids[] = $item->id;
            }
        }
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        $total = $courses->sum('price');
        //Apply Tax
        $taxData = $this->applyTax('total');


        return view($this->path . '.cart.checkout', compact('courses', 'bundles','total','taxData'));
    }

    public function addToCart(Request $request)
    {
        if(!auth()->check()) return redirect()->route('user_register');
        $product = "";
        $teachers = "";
        $type = "";
        if ($request->has('course_id')) {
            $product = Course::findOrFail($request->get('course_id'));
            $teachers = $product->teachers->pluck('id', 'name');
            $type = 'course';

        } elseif ($request->has('bundle_id')) {
            $product = Bundle::findOrFail($request->get('bundle_id'));
            $teachers = $product->user->name;
            $type = 'bundle';
        }

        $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
        if (!in_array($product->id, $cart_items)) {
            Cart::session(auth()->user()->id)
                ->add($product->id, $product->title, $product->price, 1,
                    [
                        'user_id' => auth()->user()->id,
                        'description' => $product->description,
                        'image' => $product->course_image,
                        'type' => $type,
                        'teachers' => $teachers
                    ]);
        }


        Session::flash('success', trans('labels.frontend.cart.product_added'));
        return back();
    }

    public function checkout(Request $request)
    { 
        if(!auth()->check()) return redirect()->route('user_register');
      
        $userId = auth()->user()->id;
        Cart::session($userId)->clear();
        $product = "";
        $teachers = "";
        $type = "";
        $bundle_ids = [];
        $course_ids = [];
        if ($request->has('course_id')) {
            $product = Course::findOrFail($request->get('course_id'));
            $teachers = $product->teachers->pluck('id', 'name');
            $type = 'course';

        } elseif ($request->has('bundle_id')) {
            $product = Bundle::findOrFail($request->get('bundle_id'));
            $teachers = $product->user->name;
            $type = 'bundle';
        }

        $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
        if (!in_array($product->id, $cart_items)) {

            Cart::session(auth()->user()->id)
                ->add($product->id, $product->title, $product->price, 1,
                    [
                        'user_id' => auth()->user()->id,
                        'description' => $product->description,
                        'image' => $product->course_image,
                        'type' => $type,
                        'teachers' => $teachers
                    ]);
        }
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $course_ids[] = $item->id;
            }
        }
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        $total = $courses->sum('price');
        //cart actual value
        // cart value subtotal
        //Apply Tax
        $taxData = $this->applyTax('total');


        return view($this->path . '.cart.checkout', compact('courses','total','taxData'));
    }

    public function clear(Request $request)
    {
        Cart::session(auth()->user()->id)->clear();
        return back();
    }

    public function remove(Request $request)
    {
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');


        if(Cart::session(auth()->user()->id)->getContent()->count() < 2){
            Cart::session(auth()->user()->id)->clearCartConditions();
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');
            Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
            Cart::session(auth()->user()->id)->clear();
        }
        Cart::session(auth()->user()->id)->remove($request->course);
        return redirect(route('cart.index'));
    }

    public function stripePayment(Request $request)
    {
        if($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }
        //Making Order
        $order = $this->makeOrder();

        //Charging Customer
        $status = $this->createStripeCharge($request);

        if ($status == 'success') {
            $order->status = 1;
            $order->payment_type = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);

            Cart::session(auth()->user()->id)->clear();
            return redirect()->route('status');

        } else {
            $order->status = 2;
            $order->save();
            return redirect()->route('cart.index');
        }
    }

    public function paypalPayment(Request $request)
    {
        if($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $items = [];

        $cartItems = Cart::session(auth()->user()->id)->getContent();
        $cartTotal = Cart::session(auth()->user()->id)->getTotal();
        $currency = $this->currency['short_code'];

        foreach ($cartItems as $cartItem) {

            $item_1 = new Item();
            $item_1->setName($cartItem->name)/** item name **/
            ->setCurrency($currency)
                ->setQuantity(1)
                ->setPrice($cartItem->price);
            /** unit price **/
            $items[] = $item_1;
        }

        $item_list = new ItemList();
        $item_list->setItems($items);

        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($cartTotal);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription(auth()->user()->name);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('cart.paypal.status'))/** Specify return URL **/
        ->setCancelUrl(URL::route('cart.paypal.status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('failure', trans('labels.frontend.cart.connection_timeout'));
                return Redirect::route('cart.paypal.status');
            } else {
                \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
                return Redirect::route('cart.paypal.status');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
        return Redirect::route('cart.paypal.status');
    }
    
    public function offlinePayment(Request $request){
        $counter = 0;
        $items = [];
        foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
            $counter++;
            array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
        }
        
        $user_id = Auth::user()->id;  
        $balance = Auth::user()->available_credit;
        $product_balance = $cartItem->price;
        if($product_balance > $balance){
            return redirect('/wallet')->with('success','Sorry! You do not have enough credit to purchase any products now.');
        }
        if($this->checkDuplicate()) {
             return redirect('/courses')->with('error','You already purchased this course. Please select another course');
        }
        
        $course_id = $cartItem->id;
        $price = $cartItem->price;
        $course_name = $cartItem->name;
        $card_status = 1;
        //add bill course
        if(auth()->user()->credits > 0 ){
            $card_status = 2;
        }
        CourseBill::create([
            'user_id'=>Auth::user()->id,
            'course_id'=>$course_id,
            'course_name'=>$course_name,
            'price'=>$price,
            'referral_id'=>auth()->user()->referred_by,
            'commission'=>!empty(auth()->user()->referred_by) ? 5 :NULL,
            'purchase_date'=>Carbon::today()->format('Y-m-d 00:00:00'),
            'billing_date'=>Carbon::today()->addDays(31)->format('Y-m-d 00:00:00'),
            'card_status'=>$card_status
        ]);
        //Add Order
        $order = $this->makeOrder();
        $order->payment_type = 3;
        $order->status = 1;
        $order->save();
        $this->addTransactionHistory($product_balance,$course_id,$course_name);
        
        // $content['items'] = $items;
        // $content['total'] = Cart::session(auth()->user()->id)->getTotal();
        // $content['reference_no'] = $order->reference_no;

        // try {
        //  //   \Mail::to(auth()->user()->email)->send(new OfflineOrderMail($content));
        // } catch (\Exception $e) {
        //     \Log::info($e->getMessage() . ' for order ' . $order->id);
        // }

        Cart::session(auth()->user()->id)->clear();
        \Session::flash('success', trans('labels.frontend.cart.offline_request'));
        return redirect('user/dashboard')->with('message','Course add successfully!');
        
    }
    
    public function addTransactionHistory($price,$course_id,$course_name){
        $user = User::find(auth()->user()->id);
        if($user->credits > 0 ){
            $user->credits -= 1;
            $user->save();
            Transactions::create([
                'user_id'=>Auth::user()->id,
                'transaction_type'=>'Course Purchase',
                'amount'=>$price,
                'remaining_credit'=>Auth::user()->available_credit,
                'date'=>Carbon::today()->format('Y-m-d H:i:s'),
                'referral_id'=>auth()->user()->referred_by,
                'commission'=>!empty(auth()->user()->referred_by) ? 5:NULL,
                'owe_amount'=>-$price,
                'card_status'=>2,
                'course_id'=>$course_id,
                'course_name'=>$course_name
            ]);
        }
        else{
            Transactions::create([
                'user_id'=>Auth::user()->id,
                'transaction_type'=>'Course Purchase',
                'amount'=>$price,
                'remaining_credit'=>Auth::user()->available_credit - $price,
                'date'=>Carbon::today()->format('Y-m-d H:i:s'),
                'referral_id'=>auth()->user()->referred_by,
                'commission'=>!empty(auth()->user()->referred_by) ? 5:NULL,
                'owe_amount'=>-$price,
                'course_id'=>$course_id,
                'course_name'=>$course_name
            ]);
            $user->available_credit -= $price;
            $user->current_credit += $price;
            $user->last_statement_credit += $price;
            $user->save();
            
        }
        
    }

//     public function offlinePayment(Request $request)
//     {
//         $counter = 0;
//         $items = [];
//         foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
//             $counter++;
//             array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
//         }
        
        
//          $user_id = Auth::user()->id;  
//          $getnwmodel = new BillingModel();
//          $getbalancedata = $getnwmodel->getsubdata($user_id);
         
//          $balance = $getbalancedata[0]->balance;
         
//          $balance = (float) str_replace(',', '', $balance);
        
//          $product_balance = $cartItem->price;
          
         
         
//          if($product_balance > $balance){
            
            
//           return redirect('/wallet')->with('success','Sorry You have no sufficient Balance For Buy This Product Please Contact Author');
             
//         }
         
//         if($this->checkDuplicate()) {
//              return redirect('/courses')->with('error','This course has already been purchased ones. Please choose other course');
//         }
//         //Making Order
//         $order = $this->makeOrder();
//         $order->payment_type = 3;
//         $order->status = 1;
//         $order->save();
//         $content = [];
//         $items = [];
//         $counter = 0;
//         foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
//             $counter++;
//             array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
//         }
//         if(isset($cartItem)){
           
//           $user_id = Auth::user()->id;  
//           $course_id = $cartItem->id;
//           $price = $cartItem->price;
//           $course_name = $cartItem->name;
//           date_default_timezone_set('Asia/Kolkata');
//           $purchase_data = date("Y/m/d");
//           $timestamp = strtotime( $purchase_data);
//           $new_Month_year = date('M Y', $timestamp);

     
//             $newBillingmodel = new BillingModel();
//             $user_id = Auth::user()->id;  
//             $data =  $newBillingmodel->fetchsingledate( $user_id);


//           if($data == '' ){

//             $billing_date = date('Y-m-d', strtotime('+1 month'));
//             $year = date('Y');
//             $month = date('m');
//             $total_monthdays =  cal_days_in_month(CAL_GREGORIAN, $month,$year);
//             /**========= Start subtraction billing dayes */
//             $add_purchaseDate = strtotime($purchase_data);
//             $add_billing_Date = strtotime($billing_date);
//             $billing_days = round(abs($add_purchaseDate - $add_billing_Date) / (60*60*24),0);
//             /**========= End subtraction billing days */




//              /**======monhtly due cost */
//              $course_cost = $price * 29.99/100;
//              $yearly_cost =  $course_cost/12;
//              $monthly_cost =  $yearly_cost/30;
//              $perday_interest = $monthly_cost * $billing_days;
//              $interest_to_decimal =  number_format("$perday_interest",2);

//              $course_monthly = $price/12;
//              $course_costday = $course_monthly/$total_monthdays;
//              $finalcourse_monthlydue = $course_costday*$billing_days;
//              $decimal_finalcourse_monthlydue =  number_format("$finalcourse_monthlydue",2);
//              /**======monhtly due cost */
             
             
             
//             /*==== Annual Membership===*/
//             $year = date('Y');
//             $month = date('m');
//             $total_monthdays =  cal_days_in_month(CAL_GREGORIAN, $month,$year);
//              $course_cost = $price * 29.99/100;
//              $yearly_cost =  $course_cost/12;
//              $monthly_cost =  $yearly_cost/30;
            
             
//              $annual_membership = 99.99;
//              $montlhy_membershipcost = $annual_membership/12;
//              $decimal_membershipcost = number_format("$montlhy_membershipcost",2);
             
//              $perday_interest = $monthly_cost * $billing_days;
//              $interest_to_decimal =  number_format("$perday_interest",2);
            
//              $course_monthly = $price/12;
//              $course_costday = $course_monthly/$total_monthdays;
//              $finalcourse_monthlydue = $course_costday*$billing_days;
//              $decimal_finalcourse_monthlydue =  number_format("$finalcourse_monthlydue",2);
            
//             /*===== Annual Membership=====*/



//              /**======Due Amount interest====== */
//              $course_interest = $price * 29.99/100; 
//              $monthly_interest =  $course_interest/12;
//              $perday_interest =  $monthly_interest / $total_monthdays;
//              $interest_to_decimal =  number_format("$perday_interest",2);
//              $finalcourse_monthlyinterest = $perday_interest*$billing_days;
//              $decimal_finalcourse_monthlyinterest =  number_format("$finalcourse_monthlyinterest",2);
//              $total_monthly_due = $decimal_finalcourse_monthlydue +  $decimal_finalcourse_monthlyinterest;
//              /**======Due Amount interest======== */
            
              
    
//             $transBillingData = array('user_id'=>$user_id,'course_id'=>$course_id,'price'=>$price,'purchase_date'=>$purchase_data,'billing_date'=>$billing_date,'course_name'=>$course_name,
//             'billing_days'=>$billing_days,'interest'=>$interest_to_decimal,'due_amountcourse'=>$decimal_finalcourse_monthlydue,
//             'due_amount_interest'=>$decimal_finalcourse_monthlyinterest,'total_monthly_due'=>$total_monthly_due,'monthly_membership'=>$decimal_membershipcost,'justAdded'=>1,'getmonth_membership'=>1);
//             $newBillingmodel = new BillingModel();
//             $newBillingmodel->addbilling($transBillingData);
//             $this->addTransactionHistory();
//           }
          
//           else{
     
//             $showmonth = $data->purchase_date;
//             $userfirst_date = $data->billing_date;
//             $get_newDate = date("d",strtotime($userfirst_date));
//             $userBilling_date = date("Y-m-$get_newDate",strtotime($userfirst_date));
//             $timestamp = strtotime( $showmonth ); 
//             $old_Month_year = date('M Y', $timestamp);
             


           
//             if($new_Month_year == $old_Month_year)
            
            
//             {
                    
    
//               $billing_date =  $userBilling_date;
              
      
//               /**========= Start subtraction billing dayes */
//             $add_purchaseDate = strtotime($purchase_data);
//             $add_billing_Date = strtotime($billing_date);
//             $billing_days = round(abs($add_purchaseDate - $add_billing_Date) / (60*60*24),0);
//             /**========= End subtraction billing dayes */

//             $user_id = Auth::user()->id;  
//             $date1 =  $newBillingmodel->lowestsingledate( $user_id);
//             $get_firstDate = $date1->billing_date;
        
//             $get_latestfirstdays= date("d",strtotime( $purchase_data));
//             $get_oldestfirstdays= date("d",strtotime($get_firstDate));





//             /*==== monthly bill===*/
//             $year = date('Y');
//             $month = date('m');
//             $total_monthdays =  cal_days_in_month(CAL_GREGORIAN, $month,$year);
//              $course_cost = $price * 29.99/100;
//              $yearly_cost =  $course_cost/12;
//              $monthly_cost =  $yearly_cost/30;
//              $perday_interest = $monthly_cost * $billing_days;
//              $interest_to_decimal =  number_format("$perday_interest",2);

//              $course_monthly = $price/12;
//              $course_costday = $course_monthly/$total_monthdays;
//              $finalcourse_monthlydue = $course_costday*$billing_days;
//              $decimal_finalcourse_monthlydue =  number_format("$finalcourse_monthlydue",2);

//             /*=====monthly bill=====*/
            
//             /**======Due Amount interest====== */
//             $course_interest = $price * 29.99/100;
//             $monthly_interest =  $course_interest/12;
//             $perday_interest =  $monthly_interest / $total_monthdays;
//             $interest_to_decimal =  number_format("$perday_interest",2);
//             $finalcourse_monthlyinterest = $perday_interest*$billing_days;
//             $decimal_finalcourse_monthlyinterest =  number_format("$finalcourse_monthlyinterest",2);
//             $total_monthly_due = $decimal_finalcourse_monthlydue +  $decimal_finalcourse_monthlyinterest;
//             /**======Due Amount interest======== */


            
//           if($get_latestfirstdays < $get_oldestfirstdays){

//             $billing_days =  $get_oldestfirstdays - $get_latestfirstdays;

//              /*==== monthly bill===*/
//              $year = date('Y');
//              $month = date('m');
//              $total_monthdays =  cal_days_in_month(CAL_GREGORIAN, $month,$year);
//               $course_cost = $price * 29.99/100;
//               $yearly_cost =  $course_cost/12;
//               $monthly_cost =  $yearly_cost/30;
//               $perday_interest = $monthly_cost * $billing_days;
//               $interest_to_decimal =  number_format("$perday_interest",2);
 
//               $course_monthly = $price/12;
//               $course_costday = $course_monthly/$total_monthdays;
//               $finalcourse_monthlydue = $course_costday*$billing_days;
//               $decimal_finalcourse_monthlydue =  number_format("$finalcourse_monthlydue",2);

              
 
//           /*=====monthly bill=====*/
            
//           /**======Due Amount interest====== */
//           $course_interest = $price * 29.99/100;
//           $monthly_interest =  $course_interest/12;
//           $perday_interest =  $monthly_interest / $total_monthdays;
//           $interest_to_decimal =  number_format("$perday_interest",2);
//           $finalcourse_monthlyinterest = $perday_interest*$billing_days;
//           $decimal_finalcourse_monthlyinterest =  number_format("$finalcourse_monthlyinterest",2);
//           $total_monthly_due = $decimal_finalcourse_monthlydue +  $decimal_finalcourse_monthlyinterest;
//             /**======Due Amount interest======== */

//             $transBillingData = array('user_id'=>$user_id,'course_id'=>$course_id,'price'=>$price,'purchase_date'=>$purchase_data,'billing_date'=>$get_firstDate,'course_name'=>$course_name,
//             'billing_days'=>$billing_days,'interest'=>$interest_to_decimal,'due_amountcourse'=>$decimal_finalcourse_monthlydue,
//             'due_amount_interest'=>$decimal_finalcourse_monthlyinterest,'total_monthly_due'=>$total_monthly_due,'getmonth_membership'=>0);
//             $newBillingmodel = new BillingModel();
//             $newBillingmodel->addbilling($transBillingData);
//             $this->addTransactionHistory();
//           }else{

          
            
          
//               $transBillingData = array('user_id'=>$user_id,'course_id'=>$course_id,'price'=>$price,'purchase_date'=>$purchase_data,'billing_date'=>$billing_date,'course_name'=>$course_name,
//               'billing_days'=>$billing_days,'interest'=>$interest_to_decimal,'due_amountcourse'=>$decimal_finalcourse_monthlydue,
//               'due_amount_interest'=>$decimal_finalcourse_monthlyinterest,'total_monthly_due'=>$total_monthly_due,'getmonth_membership'=>0);
//               $newBillingmodel = new BillingModel();
//              $newBillingmodel->addbilling($transBillingData);
//               $this->addTransactionHistory();

//           }
            
//     }
    
    
//     else{
           
//       $billing_date = date('Y-m-d', strtotime('+1 month'));
//       $get_newmonthDate = date("Y-m-$get_newDate",strtotime($billing_date));

//       /**========= Start subtraction billing dayes */
//         $add_purchaseDate = strtotime($get_newmonthDate);
//         $add_billing_Date = strtotime($purchase_data);
//         $billing_days = round(abs($add_purchaseDate - $add_billing_Date) / (60*60*24),0);

//             $user_id = Auth::user()->id;  
//             $date1 =  $newBillingmodel->lowestsingledate( $user_id);
//             $date2 =  $newBillingmodel->fetchsingledate( $user_id);
//             $get_latest_date  =$date2->billing_date;
//             $get_firstDate = $date1->billing_date;
             
            

            
//             $get_latestfirstdays= date("d",strtotime( $purchase_data));
//             $get_oldestfirstdays= date("d",strtotime($get_firstDate));
            
//           /* $day = strtotime($get_newmonthDate);
//             $day1 = strtotime($get_newmonthDate);*/

//              $course_cost = $price * 29.99/100;
//              $yearly_cost =  $course_cost/12;
//              $monthly_cost =  $yearly_cost/30;
//              $perday_intesrest = $monthly_cost * $billing_days;
//              $interest_to_decimal =  number_format("$perday_intesrest",2);


//               /*==== monthly bill===*/
//             $year = date('Y');
//             $month = date('m');
//             $total_monthdays =  cal_days_in_month(CAL_GREGORIAN, $month,$year);
//              $course_cost = $price * 29.99/100;
//              $yearly_cost =  $course_cost/12;
//              $monthly_cost =  $yearly_cost/30;
//              $annual_membership = 99.99;
//              $montlhy_membershipcost = $annual_membership/12;
//              $decimal_membershipcost = number_format("$montlhy_membershipcost",2);
//              $perday_interest = $monthly_cost * $billing_days;
//              $interest_to_decimal =  number_format("$perday_interest",2);

//              $course_monthly = $price/12;
//              $course_costday = $course_monthly/$total_monthdays;
//              $finalcourse_monthlydue = $course_costday*$billing_days;
//              $decimal_finalcourse_monthlydue =  number_format("$finalcourse_monthlydue",2);

//                 /*=====monthly bill=====*/


//                  /**======Due Amount interest====== */
//       $course_interest = $price * 29.99/100;
//       $monthly_interest =  $course_interest/12;
//       $perday_interest =  $monthly_interest / $total_monthdays;
//       $interest_to_decimal =  number_format("$perday_interest",2);
//       $finalcourse_monthlyinterest = $perday_interest*$billing_days;
//       $decimal_finalcourse_monthlyinterest =  number_format("$finalcourse_monthlyinterest",2);
//       $total_monthly_due = $decimal_finalcourse_monthlydue +  $decimal_finalcourse_monthlyinterest;
// /**======Due Amount interest======== */

            
//           if( $get_latestfirstdays < $get_oldestfirstdays){

//             $billing_days =  $get_oldestfirstdays - $get_latestfirstdays;
            
//             $course_cost = $price * 29.99/100;
//             $yearly_cost =  $course_cost/12;
//             $monthly_cost =  $yearly_cost/30;
//             $perday_intesrest = $monthly_cost * $billing_days;
//             $interest_to_decimal =  number_format("$perday_intesrest",2);

//             /*==== monthly bill===*/
//             $year = date('Y');
//             $month = date('m');
//             $total_monthdays =  cal_days_in_month(CAL_GREGORIAN, $month,$year);
//              $course_cost = $price * 29.99/100;
//              $yearly_cost =  $course_cost/12;
//              $monthly_cost =  $yearly_cost/30;
//              $perday_interest = $monthly_cost * $billing_days;
//              $interest_to_decimal =  number_format("$perday_interest",2);

//              $course_monthly = $price/12;
//              $course_costday = $course_monthly/$total_monthdays;
//              $finalcourse_monthlydue = $course_costday*$billing_days;
//              $decimal_finalcourse_monthlydue =  number_format("$finalcourse_monthlydue",2);

             

//           /*=====monthly bill=====*/

//           /**======Due Amount interest====== */
//       $course_interest = $price * 29.99/100;
//       $monthly_interest =  $course_interest/12;
//       $perday_interest =  $monthly_interest / $total_monthdays;
//       $interest_to_decimal =  number_format("$perday_interest",2);
//       $finalcourse_monthlyinterest = $perday_interest*$billing_days;
//       $decimal_finalcourse_monthlyinterest =  number_format("$finalcourse_monthlyinterest",2);
//       $total_monthly_due = $decimal_finalcourse_monthlydue +  $decimal_finalcourse_monthlyinterest;
// /**======Due Amount interest======== */

//             $transBillingData = array('user_id'=>$user_id,'course_id'=>$course_id,'price'=>$price,'purchase_date'=>$purchase_data,'billing_date'=>$get_latest_date,'course_name'=>$course_name,
//             'billing_days'=>$billing_days,'interest'=>$interest_to_decimal,'due_amountcourse'=>$decimal_finalcourse_monthlydue,
//             'due_amount_interest'=>$decimal_finalcourse_monthlyinterest,'total_monthly_due'=>$total_monthly_due,'getmonth_membership'=>0);
//             $newBillingmodel = new BillingModel();
//             $newBillingmodel->addbilling($transBillingData);
//             $this->addTransactionHistory();
//           }
           
           
//           else{
//             $transBillingData = array('user_id'=>$user_id,'course_id'=>$course_id,'price'=>$price,'purchase_date'=>$purchase_data,'billing_date'=>$get_newmonthDate,'course_name'=>$course_name,
//             'billing_days'=>$billing_days,'interest'=>$interest_to_decimal,'due_amountcourse'=>$decimal_finalcourse_monthlydue,
//             'due_amount_interest'=>$decimal_finalcourse_monthlyinterest,'total_monthly_due'=>$total_monthly_due,'monthly_membership'=>$decimal_membershipcost,'getmonth_membership'=>1);
//             $newBillingmodel = new BillingModel();
//             $newBillingmodel->addbilling($transBillingData);
//              $this->addTransactionHistory();
//           }
 
//   }
//           }
          
         
           

//         }
       

//         $content['items'] = $items;
//         $content['total'] = Cart::session(auth()->user()->id)->getTotal();
//         $content['reference_no'] = $order->reference_no;

//         try {
//          //   \Mail::to(auth()->user()->email)->send(new OfflineOrderMail($content));
//         } catch (\Exception $e) {
//             \Log::info($e->getMessage() . ' for order ' . $order->id);
//         }

//         Cart::session(auth()->user()->id)->clear();
//         \Session::flash('success', trans('labels.frontend.cart.offline_request'));
//         return redirect('user/dashboard')->with('message','courses add successfully!');
//     }
    


    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $order = $this->makeOrder();
        $order->payment_type = 2;
        $order->save();
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            Cart::session(auth()->user()->id)->clear();
            return Redirect::route('status');
        } else {
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            $order->status = 2;
            $order->save();
            return Redirect::route('status');
        }

    }

    public function getNow(Request $request)
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = str_random(8);
        $order->amount = 0;
        $order->status = 1;
        $order->payment_type = 0;
        $order->save();
        //Getting and Adding items
        if ($request->course_id) {
            $type = Course::class;
            $id = $request->course_id;
        } else {
            $type = Bundle::class;
            $id = $request->bundle_id;

        }
        $order->items()->create([
            'item_id' => $id,
            'item_type' => $type,
            'price' => 0
        ]);

        foreach ($order->items as $orderItem) {
            //Bundle Entries
            if ($orderItem->item_type == Bundle::class) {
                foreach ($orderItem->item->courses as $course) {
                    $course->students()->attach($order->user_id);
                }
            }
            $orderItem->item->students()->attach($order->user_id);
        }
        Session::flash('success', trans('labels.frontend.cart.purchase_successful'));
        return back();

    }

    public function getOffers()
    {
        $coupons = Coupon::where('status', '=', 1)->get();
        return view('frontend.cart.offers', compact('coupons'));
    }

    public function applyCoupon(Request $request)
    {
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');

        $coupon = $request->coupon;
        $coupon = Coupon::where('code', '=', $coupon)
            ->where('status', '=', 1)
            ->first();
        if ($coupon != null) {
            Cart::session(auth()->user()->id)->clearCartConditions();
            Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');

            $ids = Cart::session(auth()->user()->id)->getContent()->keys();
            $course_ids = [];
            $bundle_ids = [];
            foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
                if ($item->attributes->type == 'bundle') {
                    $bundle_ids[] = $item->id;
                } else {
                    $course_ids[] = $item->id;
                }
            }
            $courses = new Collection(Course::find($course_ids));
            $bundles = Bundle::find($bundle_ids);
            $courses = $bundles->merge($courses);

            $total = $courses->sum('price');
            $isCouponValid = false;
            if( $coupon->useByUser() < $coupon->per_user_limit ){
                $isCouponValid = true;
                if(($coupon->min_price != null) && ($coupon->min_price > 0)){
                    if($total >= $coupon->min_price){
                        $isCouponValid = true;
                    }
                }else{
                    $isCouponValid = true;
                }
                if($coupon->expires_at != null){
                    if(Carbon::parse($coupon->expires_at) >= Carbon::now()){
                        $isCouponValid = true;
                    }else{
                        $isCouponValid = false;
                    }
                }

            }

            if($isCouponValid == true){
                $type = null;
                if($coupon->type == 1){
                    $type = '-'.$coupon->amount.'%';
                }else{
                    $type = '-'.$coupon->amount;
                }

                $condition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => $coupon->code,
                    'type' => 'coupon',
                    'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => $type,
                    'order' => 1
                ));

                Cart::session(auth()->user()->id)->condition($condition);
                //Apply Tax
                $taxData = $this->applyTax('subtotal');

                $html = view('frontend.cart.partials.order-stats',compact('total','taxData'))->render();
                return ['status' => 'success', 'html' => $html];
            }


        }
        return ['status' => 'fail', 'message' => trans('labels.frontend.cart.invalid_coupon')];
    }

    public function removeCoupon(Request $request){

        Cart::session(auth()->user()->id)->clearCartConditions();
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        Cart::session(auth()->user()->id)->removeConditionsByType('tax');

        $course_ids = [];
        $bundle_ids = [];
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $course_ids[] = $item->id;
            }
        }
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        $total = $courses->sum('price');

        //Apply Tax
        $taxData = $this->applyTax('subtotal');

        $html = view('frontend.cart.partials.order-stats',compact('total','taxData'))->render();
        return ['status' => 'success', 'html' => $html];

    }

    private function makeOrder()
    {
       $coupon = Cart::session(auth()->user()->id)->getConditionsByType('coupon')->first();
       if($coupon != null){
           $coupon = Coupon::where('code','=',$coupon->getName())->first();
       }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = str_random(8);
        $order->amount = Cart::session(auth()->user()->id)->getTotal();
        $order->status = 1;
        $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
        $order->payment_type = 3;
        $order->save();
        //Getting and Adding items
        foreach (Cart::session(auth()->user()->id)->getContent() as $cartItem) {
            if ($cartItem->attributes->type == 'bundle') {
                $type = Bundle::class;
            } else {
                $type = Course::class;
            }
            $order->items()->create([
                'item_id' => $cartItem->id,
                'item_type' => $type,
                'price' => $cartItem->price
            ]);
        }
//        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        return $order;
    }

    private function checkDuplicate(){
        $is_duplicate = false;
        $message = '';
        $orders = Order::where('user_id','=',auth()->user()->id)->pluck('id');
        $order_items = OrderItem::whereIn('order_id',$orders)->get(['item_id','item_type']);
        foreach (Cart::session(auth()->user()->id)->getContent() as $cartItem) {
            if($cartItem->attributes->type == 'course'){
                foreach($order_items->where('item_type', 'App\Models\Course') as $item){
                    if($item->item_id == $cartItem->id){
                        $is_duplicate = true;
                        $message .= $cartItem->name.' '.__('alerts.frontend.duplicate_course') .'</br>';
                    }
                }
            }
            if($cartItem->attributes->type == 'bundle'){
                foreach($order_items->where('item_type', 'App\Models\Bundle') as $item){
                    if($item->item_id == $cartItem->id){
                        $is_duplicate = true;
                        $message .= $cartItem->name.''.__('alerts.frontend.duplicate_bundle') .'</br>';
                    }
                }
            }
        }

        if($is_duplicate){
            return redirect()->back()->withdanger($message);
        }
        return false;

    }

    private function createStripeCharge($request)
    {
        $status = "";
        Stripe::setApiKey(config('services.stripe.secret'));
        $amount = Cart::session(auth()->user()->id)->getTotal();
        $currency = $this->currency['short_code'];
        try {
            Charge::create(array(
                "amount" => $amount * 100,
                "currency" => strtolower($currency),
                "source" => $request->reservation['stripe_token'], // obtained with Stripe.js
                "description" => auth()->user()->name
            ));
            $status = "success";
            Session::flash('success', trans('labels.frontend.cart.payment_done'));
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for id = ' . auth()->user()->id);
            Session::flash('failure', trans('labels.frontend.cart.try_again'));
            $status = "failure";
        }
        return $status;
    }
//EMI RATE
    private function applyTax($target)
    {
        //Apply Conditions on Cart
        $taxes = Tax::where('status', '=', 1)->get();
        Cart::session(auth()->user()->id)->removeConditionsByType('tax');
        if ($taxes != null) {
            $taxData = [];
            foreach ($taxes as $tax){
                $total = Cart::session(auth()->user()->id)->getTotal();
                $numberOfMonth = 12;
                $emiRateCharges =$tax->rate/12/100; 
               
                $emiTotal=(float)($total*$emiRateCharges*(pow(($emiRateCharges+1),$numberOfMonth))/(pow(($emiRateCharges+1),$numberOfMonth)-1));
                // $total*$tax->rate/100
                $taxData[] = ['name'=> '+'.$tax->rate.'% '.$tax->name,'amount'=> $emiTotal ];
            }

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Tax',
                'type' => 'tax',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => $taxes->sum('rate') .'%',
                'order' => 2
            ));
            Cart::session(auth()->user()->id)->condition($condition);
            return $taxData;
        }
    }

}
