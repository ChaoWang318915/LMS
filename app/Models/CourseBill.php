<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
 

class CourseBill extends Model
{
    protected $table = 'course_bill';
    protected $fillable = [
        'user_id',
        'course_id',
        'course_name',
        'price',
        'status',
        'purchase_date',
        'billing_date',
        'referral_id',
        'commission',
        'card_status'
    ];

}
