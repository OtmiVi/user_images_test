<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_user_image', 'user_image_id', 'user_id')
            ->withTimestamps()->limit(1);
    }
}
