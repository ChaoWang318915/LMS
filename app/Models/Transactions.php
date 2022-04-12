<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'remaining_credit',
        'referral_id',
        'date',
        'commission',
        'status',
        'owe_amount',
        'card_status',
        'course_id',
        'course_name'
    ];
}
