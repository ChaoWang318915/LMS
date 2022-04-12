<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ewalletmodel;
use App\Models\BillingModel;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe;
use Auth;
use App\Payment;
use Illuminate\Support\Facades\Session;
use \DB;
use App\Models\Auth\User;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Transactions;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    public function stripe(){
        
        $histories = Payment::where('user_id',Auth::user()->id)->orderBy('id','desc')->take(3)->get();
        $current_balance = 0 ;
        $last_balance = 0;
        $late_fee = 0 ;
        $current_balance = Auth::user()->current_credit;
        $minimal_balance = 0 ;
        if(Auth::user()->paid_check == 2){
            $last_balance = Auth::user()->last_statement_credit;
            $minimal_balance = round($current_balance*0.15);
            // $late_fee = $this->getLateFee();
            // $current_balance += $late_fee;
            // $current_balance = round($current_balance + ($current_balance * 0.29999)/12,2);
        }
        //if late then add $  to the current balance.
        
        //last balance
        // $last_balance = round($last_balance + ($last_balance * 0.29999)/12,2);
        
        return view('payment/new-stripe',compact('histories','current_balance','last_balance','minimal_balance'));
    }
    
    public function getLateFee(){
        //start date , bill date 
        //10 - 25, 
        return 0;
    }
    
    // public function stripe()
    // {
    //   $id = Auth::user()->id;
    //   $getDATAModel = new Ewalletmodel();
      
    //   $due_date_model = new BillingModel();
    //   $due_date = $due_date_model->fetchsingledate($id);

    //   // Not using the previous wallet table because we moved all fields of wallet table to users one.
    //   //  $get_data = $getDATAModel->get_user_wallet_data();
    //     $courseBillingdata = $getDATAModel->getcourse($id);
        
    //   // Not using the user_credit table cause we moved credit field to users.
    //   //  $getAllData = $getDATAModel->getalltotalcredit($id);

    //     $getAllData = Auth::user()->credit;
    //     $membershipusersData = $getDATAModel->getmebership($id);
      
    //     $get_membershipData =  $getDATAModel->getmebershipData($id);
      
      
      
    //   $addCreditData = 0;
    //   if($getAllData > 0) {
    //     foreach($get_membershipData as $value)
    //     {
    //       $addCreditData += $value->due_amountcourse;   
    //     }

    //     User::where('id', $id)->update([
    //       'credit' => $addCreditData
    //     ]);

    //     // Not using the user credit table anymore.
    //     // $insertCredit_data = array('user_credit'=>$addcreditData);
    //     // $getDATAModel->updatetotalcredit($insertCredit_data,$id);   
        
    //   } else {
    //       $addcreditData = 0;
    //       if($get_membershipData !='') {
    //         foreach($get_membershipData as $value)
    //         {
    //           $addcreditData += $value->due_amountcourse;
    //         }
    //       }
    //       $insertCredit_data = array('user_id'=>$id,'user_credit'=>$addcreditData);
    //       $getDATAModel->addtotalcredit( $insertCredit_data);
    //   }
      
    //   if(count($courseBillingdata) <= 0) {
    //     $courses_cost = Auth::user()->courses_cost;
    //     $getinterest =  Auth::user()->interest;
    //     $membership = Auth::user()->membership;
    //     $total_cost = $courses_cost +  $membership;
    //     $final_interest = $total_cost * $getinterest/100;
    //     $monthly_interest =  $final_interest/12;
    //     $divided_cost =  $total_cost/12;
    //     $final_monthly_payment =  $divided_cost +  $monthly_interest;
    //     $send_decimal_data =  number_format($final_monthly_payment, 2);
    //     return view('payment/stripe',['generatePayment'=> $send_decimal_data,'statmentbalance'=>$total_cost]);
    //   }
      
      
    // if($courseBillingdata[0]->status == 1) {
    //   $due_amount_interest = $courseBillingdata[0]->due_amount_interest;
    //   $total_monthly_due = $courseBillingdata[0]->total_monthly_due;
    
    //   $total_amount_interest = 0;
    //   $monthly_due = 0;
    //   $monthly_membership = 0;
    //   $duepayment = 0;

    //   if($courseBillingdata != '') {
    //     foreach ($courseBillingdata as $value)
    //     {
    //       $duepayment += $value->due_amountcourse;
    //       $total_amount_interest += $value->due_amount_interest;
    //       $monthly_due += $total_monthly_due;
    //     }
    //   }   

    //     if(count($membershipusersData) > 0) {
    //       $monthlymenbersipData = $membershipusersData[0]->monthly_membership;
    //     } else {
    //       $monthlymenbersipData = 0;
    //     }
      
    //     $monthly_mebership = $monthlymenbersipData;   
    //     $monthly_mebership =  $monthlymenbersipData;
    //     $decimal_monthly = number_format($duepayment,2);
    //     $decimal_monthly_amount_interest = number_format($total_amount_interest,2);
    //     $total_payment = $decimal_monthly_amount_interest +  $duepayment +  $monthly_mebership;
    //     $decimal_total_paytment = number_format( $total_payment,2);
    //     $courses_cost = Auth::user()->courses_cost;
    //     $getinterest =  Auth::user()->interest;
    //     $membership = Auth::user()->membership;
    //     $total_cost = $courses_cost +  $membership;
    //     $final_interest = $total_cost*$getinterest/100;
    //     $monthly_interest =  $final_interest/12;
    //     $divided_cost =  $total_cost/12;
    //     $final_monthly_payment =  $divided_cost +  $monthly_interest;
    //     $send_decimal_data =  number_format($final_monthly_payment,2);
    //     return view('payment/stripe',['generatePayment'=> $send_decimal_data,'statmentbalance'=>$total_cost,'total_payment'=> $decimal_total_paytment,'total_amount_interest'=>$decimal_monthly_amount_interest,
    //       'monthly_due'=>$decimal_monthly,'monthly_mebership'=>$monthly_mebership,'due_date'=>$due_date]);

    // } else {
    //     $send_decimal_data = 0;
    //     $total_cost= 0;
    //     $total_payment= 0;
    //     $decimal_monthly_amount_interest= 0;
    //     $decimal_monthly= 0;
    //     $monthly_mebership= 0;
    //     $due_date= 0;

    //     return view('payment/stripe',['generatePayment'=> $send_decimal_data,'statmentbalance'=>$total_cost,'total_payment'=>$total_payment,'total_amount_interest'=>$decimal_monthly_amount_interest,
    //       'monthly_due'=>$decimal_monthly,'monthly_mebership'=>$monthly_mebership,'due_date'=>$due_date]);
    //     }
       
    // }

    public function checkMethod(Request $request){
        request()->validate([
            'pay_option' => 'required',
            
        ]);
        if($request->pay_option == "2"){
            request()->validate([
                'amount' => 'required',
            ]);
        }
        $amount = 0;
        if($request->pay_option == 1) $amount = $request->min_amount;
        elseif($request->pay_option == 2) $amount = $request->amount;
        elseif($request->pay_option == 3) $amount = $request->current_balance;
        elseif($request->pay_option == 4) $amount = $request->last_balance;
        return redirect()->back()->with('message',$amount);
    }
    
    public function makePayment(Request $request){
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $Srp_Data =   Stripe\Charge::create ([
                "amount" =>  $request->amount*100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment made on Dotcom Lessons " 
        ]);
        
        $user_id = Auth::user()->id;
        $payment_date = date('Y-m-d');
        $reference = time();
        $data_insertStrp = array('s_payment_id'=>$Srp_Data->id,'user_id'=>$user_id,'amount'=>$request->amount,'payment_date'=>$payment_date,'reference'=>$reference);
        DB::table('payments')
          ->insert($data_insertStrp);
        Transactions::create([
            'user_id'=>Auth::user()->id,
            'transaction_type'=>'Make Payment',
            'amount'=>$request->amount,
            'remaining_credit'=>Auth::user()->available_credit,
            'date'=>Carbon::today()->format('Y-m-d H:i:s'),
            'commission'=>!empty(auth()->user()->referred_by) ? 5:NULL
        ]);
        $amount = $request->amount;
        $flag = 1;
        
        $transactions = Transactions::where('user_id',auth()->user()->id)
            ->whereIn('transaction_type',array('Annual Gold package','Course Purchase'))
            ->where('card_status',1)
            ->orderBy('id','asc')->where('status',1)->get();
        foreach($transactions as $transaction){
            if($flag == 1){
                if($amount >= $transaction->owe_amount){
                    $transaction->owe_amount = 0;
                    $transaction->status = 2;
                    $transaction->save();
                    $amount = $amount - $transaction->owe_amount;
                }
                else{
                    $transaction->owe_amount = $transaction->owe_amount - $amount;
                    $transaction->save();
                    $flag = 2;
                }
            }
            
        }
        //Step - 1 1 tier commission - $30 / $10, 2 tier commission - $15/$5
        if(!empty(auth()->user()->referred_by)){
            $ref_user = User::find(auth()->user()->referred_by);
            if(!empty($ref_user)){
                $ref_user_2 = null;
                if(!empty($ref_user->referred_by)){
                    $ref_user_2 = User::find($ref_user->referred_by);
                }
                $transactions = Transactions::where('user_id',auth()->user()->id)
                    ->whereIn('transaction_type',array('Annual Gold package','Course Purchase'))
                    ->where('card_status',1)
                    ->orderBy('id','asc')->where('status',2)->get();
                foreach($transactions as $trans){
                    if($trans->transaction_type == 'Annual Gold package'){
                        $ref_user->commission += 30;
                        if(!empty($ref_user_2)) $ref_user_2->commission += 15;
                    }
                    else{
                        $ref_user->commission += 10;
                        if(!empty($ref_user_2)) $ref_user_2->commission += 5;
                    }
                    $trans->status = 3;
                }
            }
        }
        $user = User::find($user_id);
        $user->available_credit += $request->amount;
        
        if($user->paid_check == 2){
            $user->last_statement_credit = $user->current_credit - $request->amount;    
            $user->current_credit = 0;
        }
        else{
            $user->current_credit = $user->current_credit - $request->amount;    
        }
        $user->paid_check = 1;
        $user->f_pay_status = 1;
        $user->save();
        // email data
        $email_data = array(
            'first_name'=>$user->first_name,
            'last_name' =>$user->last_name,
            'amount'=>$request->amount,
        );
        //send email to no-reply@dotcomlessons
        Mail::send('emails.make_payment', $email_data, function ($message) use ($email_data) {
            $message->to('no-reply@dotcomlessons.com', $email_data['first_name'])
                ->subject('Make new Payment on dotcomlessons')
                ->from('welcome@dotcomlessons.com', 'DotComLessons');
        });
        Session::flash('success', 'Payment Successful!');
        return back();
    }
    
  public function stripePost(Request $request,$amount)
  {
    $due_date_model = new BillingModel();
    $id = Auth::user()->id;
    $getDATAModel = new Ewalletmodel();
    
    // Not using the previous wallet table because we moved all fields of wallet table to users one.
    // $get_data = $getDATAModel->get_user_wallet_data();

    $getsubData = $getDATAModel->getsubtract($id);
    
    $getusers_credit =  $getDATAModel ->getalltotalcredit($id);
    $finalusers_credit = $getusers_credit[0]->user_credit;
    $getbalance =  $getsubData[0]->balance;
    
    $courses_cost = Auth::user()->courses_cost;
    $getinterest =  Auth::user()->interest;
    $membership = Auth::user()->membership;
    $total_cost = $courses_cost +  $membership;
    $final_interest = $total_cost*$getinterest/100;
    $monthly_interest =  $final_interest/12;
    $divided_cost =  $total_cost/12;
    $final_monthly_payment =  $divided_cost +  $monthly_interest;
    $send_decimal_data =  number_format($final_monthly_payment,2);
    
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $Srp_Data =   Stripe\Charge::create ([
            "amount" =>  $amount * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Payment made on Dotcom Lessons " 
    ]);
    
    $user_id = Auth::user()->id;
    $amount = $Srp_Data->amount;
    $conver_decimal_amount = $amount/100;
    $payment_date = date('Y-m-d');
    $data_insertStrp = array('s_payment_id'=>$Srp_Data->id,'user_id'=>$user_id,'amount'=>$conver_decimal_amount,'payment_date'=>$payment_date);
    DB::table('payments')
      ->insert($data_insertStrp);
    
    $getbalance = (float) str_replace(',', '',$getbalance);
    $finalusers_credit =  (float) str_replace(',', '',$finalusers_credit);
    
    $add_blance_credit = $getbalance + $finalusers_credit;
    $add_decimal_credit = number_format($add_blance_credit,2);
    $addbalance_credit = array('balance'=>$add_decimal_credit);
    
    $getDATAModel->updatesub($addbalance_credit,$id);
      
    $updateData = array('getmonth_membership'=>0);
    
    // DB::table('bill_generation')
    //   ->where('user_id',$user_id)
    //   ->update($updateData);
    
    // $update_data = array('status'=>0);
    // DB::table('bill_generation')
    //   ->where('user_id',$user_id)
    //   ->update($update_data);

    Session::flash('success', 'Payment Successful!');
    return back();
  }              

}