<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function getUsers()
    {
        $users = User::select('users.name', 'users.city')
            ->leftJoin('user_user_image', 'users.id', '=', 'user_user_image.user_id')
            ->selectRaw('COUNT(user_user_image.user_id) AS images_count')
            ->groupBy('users.id', 'users.name', 'users.city')
            ->orderByDesc('images_count')
            ->paginate(100);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'city' => $request->input('city'),
        ]);

        $user->images()->create([
            'image' => $request->input('image'), // Replace with actual image data
        ]);

        return response()->json($user, 201);
    }
}
