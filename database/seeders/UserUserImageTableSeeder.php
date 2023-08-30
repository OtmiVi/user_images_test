<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserUserImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $userImages = UserImage::all();

        foreach ($userImages as $image) {
            $image->user()->attach($users->random());
        }
    }
}
