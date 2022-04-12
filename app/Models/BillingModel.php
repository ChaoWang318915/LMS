<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use \DB;

class BillingModel extends Model


{

function addbilling($transBillingData)


{

    DB::table('bill_generation')
    ->insert($transBillingData);
}



function fecth_meunItem(){

  return  DB::table('admin_menu_items')
    ->select('label','link')
    ->where('menu',2)
    ->get();
}


function fetchsingledate($id){

  return DB::table('bill_generation')
  ->where('user_id',$id)
  ->latest('billing_date')->first();
 
  }
  
function fetchbillsbyUserId($id){

  return DB::table('bill_generation')
  ->where('user_id',$id)
  ->get();
 
  }
  
  function getcredit($id){

  return DB::table('bill_generation')
  ->where('user_id',$id)
  ->where('status',1)
  ->get();
 
  }
  
  function user_credit($id){

  return DB::table('users_credit')
  ->where('user_id',$id)
  ->get();
 
  }
  
  
  
  public function getsubdata(){
        
        return  DB::table('sub_billing')
       ->select('*')
       ->get();
    
    }

  function lowestsingledate($id){

    return DB::table('bill_generation')
    ->where('user_id',$id)
    ->oldest('billing_date')->first();
   
    }

}