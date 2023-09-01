<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUserImage extends Model
{
    use HasFactory;

    protected $table = 'user_user_image';

    protected $fillable = [
        'user_id',
        'user_image_id'
    ];
}
