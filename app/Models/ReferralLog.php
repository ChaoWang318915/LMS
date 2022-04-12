<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
 

class ReferralLog extends Model
{
    protected $table = 'referral_log';
    protected $fillable = [
        'user_id',
        'referral_id',
        'ip_address',
        'site_name',
        'date',
    ];

}
