<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        //$users = User::withCount('images')->orderBy('images_count', 'desc')->paginate(100);
        $users = User::withCount('images')->sortBy('images_count')->paginate(100);
        $data = $users->sortBy('images_count');
        dd($data);


        return response()->json($data);
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
