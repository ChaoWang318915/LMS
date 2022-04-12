<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
 

class InviteEmail extends Model
{
    protected $table = 'invite_email';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'date',
    ];

}
