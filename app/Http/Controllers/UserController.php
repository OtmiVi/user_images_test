<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use App\Models\UserUserImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class UserController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * @return JsonResponse
     */
    public function getUsers()
    {
        try {
            /**
             * @var User $users
             */
            $users = User::select('users.name', 'users.city')
                ->leftJoin('user_user_image', 'users.id', '=', 'user_user_image.user_id')
                ->selectRaw('COUNT(user_user_image.user_id) AS images_count')
                ->groupBy('users.id', 'users.name', 'users.city')
                ->orderByDesc('images_count')
                ->paginate(100);

            return response()->json([
                'status' => true,
                'data' => $users
            ], 201);
        } catch (Throwable  $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('uploads', 'public');
                /**
                 * @var UserImage $image
                 */
                $image = UserImage::create([
                    'image' => $path
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Image don't found"
                ], 404);
            }

            /**
             * @var User $users
             */
            $user = User::create([
                'name' => $request->input('name'),
                'city' => $request->input('city'),
            ]);

            UserUserImage::create([
                'user_id' => $user->id,
                'user_image_id' => $image->id
            ]);

            return response()->json([
                'status' => true,
                'message' => "User created successfully",
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()['name'],
            ], 422);
        } catch (Throwable  $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
