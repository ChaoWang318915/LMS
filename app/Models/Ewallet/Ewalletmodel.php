<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use \DB;
class Ewalletmodel extends Model
{
    protected $table = 'bill_generation';
    public $timestamps = false;

    public function get_user_wallet_data(){
        return DB::table('wallet')
       ->select('*')
       ->get();
    }


 public function getBillById($id){
        
        return $this->where('id',$id)
        ->first();
    
    }

    public function getcoursebill($id){
        
        return DB::table('bill_generation')
        ->select('*')
        ->where('user_id',$id)
        ->where('status',1)
        ->get();
    
    }
    public function getcoursebillSkipFirst($id){
        
        return DB::table('bill_generation')
        ->select('*')
        ->where('user_id',$id)
        ->orderBy('id','desc')
        ->get();
    
    }
    
     
    public function getsinglebill($id){
        
        return DB::table('bill_generation')
        ->select('*')
        ->where('user_id',$id)
        ->where('status',1)
        ->skip(1)
        ->take(50)
        ->get();
    
    }
    
    public function getmebership($id){
        
        return DB::table('bill_generation')
        ->select('*')
        ->where('getmonth_membership',1)
         ->get();
    
    }
    
     public function getmebershipData($id){
        
        return DB::table('bill_generation')
        ->where('user_id',$id)
        ->where('status',1)
        ->select('*')
        ->get();
    
    }
    
    
    
    public function addtotalcredit($addtotalcredit){
        
      DB::table('users_credit')
       ->insert($addtotalcredit);
    
    }
    
    
     public function getalltotalcredit($id){
        
      return DB::table('users_credit')
      ->where('user_id',$id)
       ->get();
    
    }
    
    
     public function updatetotalcredit($addtotalcredit,$id){
        
      DB::table('users_credit')
       ->where('user_id',$id)
       ->update($addtotalcredit);
    
    }
    
    public function updatesub($update,$id){
        
         DB::table('sub_billing')
        ->where('user_id',$id)
       ->update($update);
    
    }
    
    
    
     public function getsubdata(){
        
        return  DB::table('sub_billing')
       ->select('*')
       ->get();
    
    }
    
    public function getsubtract($id){
         return DB::table('sub_billing')
        ->where('user_id',$id)
        ->select('*')
        ->get();
    
    }
    
    
    public function insertsubdata($insert){
        return  DB::table('sub_billing')
       ->insert($insert);
        
    }
    
     public function getcourse($id){
        
        return DB::table('bill_generation')
        ->select('*')
        ->where('user_id',$id)
        ->where('status',1)
        ->get();
    
    }
    
   
}
