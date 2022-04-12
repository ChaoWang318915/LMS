<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadImage extends Model
{
    protected $table = 'upload_image';
    protected $fillable = [
        'user_id',
        'file_name',
    ];
}
