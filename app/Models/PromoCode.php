<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 

class PromoCode extends Model
{
    protected $table = 'promo_code';
    protected $fillable = [
        'promo_code',
        'start_date',
        'end_date',
        'type',
        'discount_amount',
    ];

}
