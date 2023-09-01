<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city'
    ];

    public function images()
    {
        return $this->belongsToMany(UserImage::class, 'user_user_image', 'user_id', 'user_image_id')
            ->withTimestamps();
    }
}
