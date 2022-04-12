<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use \Auth;
use App\Models\Ewalletmodel;
use Illuminate\Http\Request;
use App\Models\CourseBill;
use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\ReferralLog;
use App\Models\Transactions;
use App\Models\Page;

class EwalletController extends Controller
{

    public function showallet(){
        
        $available_credit = Auth::user()->available_credit;
        $total_credit = Auth::user()->total_credit;
        $courses = CourseBill::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        foreach($courses as $course){
            $course->purchase_date = Carbon::parse($course->purchase_date)->format('m-d-Y');
            $course->billing_date = Carbon::parse($course->billing_date)->format('Y-m-d');
        }
        $user = User::find(Auth::user()->id);
        $user->referral_cnt = ReferralLog::where('user_id','!=',NULL)->where('referral_id',$user->id)->get()->groupBy('referral_id')->count();
        $user->bill_date = Carbon::parse($user->bill_date)->format('M d, Y');
        $dashboard = Page::find(8);
        $aff_dashboard = Page::find(19);
        $current_balance = Auth::user()->current_credit;
        //$last_balance = round($last_balance + ($last_balance * 0.29999)/12,2);
        //get tier 2 count
        $tier_1_ids = User::where('referred_by',auth()->user()->id)->pluck('id')->toArray();
        $tire_2_cnt = User::whereIn('referred_by',$tier_1_ids)->get()->count();
        $user->tier_2_cnt = $tire_2_cnt;
        if($user->hasRole('affiliate')) return view('ewallet.affiliate_ewallet',compact('user','aff_dashboard'));
        else  return view('ewallet.new-ewallet',compact('available_credit','total_credit','courses','user','dashboard','current_balance'));
    }
/*
    public function showallet(){
     
       if(!auth()->check()){

        return redirect('/');
       }
       
       $id = Auth::user()->id;
       $getDATAModel = new Ewalletmodel();
       $get_data = $getDATAModel->get_user_wallet_data();
       $courseBillingdata = $getDATAModel->getcoursebillSkipFirst( $id );
       $coursesinglegdata = $getDATAModel->getsinglebill( $id );
       $data = $getDATAModel->getsubdata();
       
       
       $getbalanceData = $getDATAModel->getsubtract($id);
       
       $total = $get_data[0]->total_credit;
       $balance  = $get_data[0]->available_credit;
       
       $get_dataid = array();
   
        foreach($data as $value){
              
            $get_dataid[] =  $value->user_id;
        }
         
        $findid = $get_dataid;
   
        if(in_array($id, $findid)){
        
        }else{
         
            $data = array('user_id'=>$id,'balance'=>$balance);
            $getDATAModel = new Ewalletmodel();
            $data = $getDATAModel->insertsubdata($data);
        }
        

        if(count($courseBillingdata) <= 0){
           if(count($getbalanceData) <= 0){
               
                $getbalanceData = $balance;
                return view('ewallet/ewallet',['transwalletData'=>$get_data,'balance'=>$getbalanceData]);
           }
            return view('ewallet/ewallet',['transwalletData'=>$get_data,'balance'=>$getbalanceData[0]->balance]);
       }
     
       $price = $courseBillingdata[0]->price;
       $billing_days = $courseBillingdata[0]->billing_days;
       $total_credit = $get_data[0]->total_credit;
       $course_cost = $get_data[0]->courses_cost;
       $membership = $get_data[0]->membership;
       $balancecredit = $total_credit- $course_cost;
       
        if(isset($getbalanceData) && !empty($getbalanceData)){
           $final_credit = $getbalanceData[0]->balance;
           
        }else{
            $final_credit = $balancecredit-$membership;
        }
      
       
        $total_course = 1;
        $sum = 0;
        $duepayment = 0;
        $course= 1;
      
       
        if($courseBillingdata != ''){
            foreach ($courseBillingdata as $value) {
                $sum += $value->price;
                $duepayment += $value->total_monthly_due;
                $total_course =  $course++;
            }
        }
        $testsum = 0;
           
              
        $courseBillingdataJustAddedCount = $courseBillingdata->reject(function($value){
            if($value->justAdded == 1)
                return true;
          })->count();
        if($courseBillingdataJustAddedCount >=1){
            $coursesAdded =  $courseBillingdata->reject(function($value){
                if($value->justAdded == 1)
                    return true;
              });
              
            foreach ($coursesAdded as $value) {
                   $testsum += $value->price;
            }
             $final_credit = (float) str_replace(',', '',$final_credit);
                  $substract_crtedit =  $final_credit - $testsum;
                  $interest_totaldays = $duepayment;
                  
                  $decimal_payment = number_format("$interest_totaldays",2);
                  $updatesub = array('balance'=>$substract_crtedit);
                  $getDATAModel->updatesub($updatesub,$id);
                  foreach($courseBillingdata as $billingdata){
                      
                      $wallet = new Ewalletmodel();
                      $bill = $wallet->getBillById($billingdata->id);
                      $bill->justAdded = 1;
                      $bill->save();
                  }
                 
        }
        else{
             $final_credit = (float) str_replace(',', '',$final_credit);
                  $substract_crtedit =  $final_credit;
                  $interest_totaldays = $duepayment;
                  $decimal_payment = number_format("$interest_totaldays",2);
                  $testsum=0;
                 
        }
       $balance = Auth::user()->available_credit;
       return view('ewallet/ewallet',['transwalletData'=>$get_data,'finalcredit'=>$final_credit,'coursecbilling'=>$courseBillingdata,
       'sum'=>$substract_crtedit,'sumtotalcourse'=> $total_course,'monthlydue'=>$decimal_payment,'test'=>$testsum,'balance'=>$balance]);
   }
       
  */ 
}
