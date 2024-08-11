<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get()
    {
        $user = User::with("address")->get();

        return ProfileResource::collection($user);
    }
    public function profile()
    {
        $userId = Auth::user()->id;

        $user = User::with("address")->findOrFail($userId);

        return new ProfileResource($user);
    }
    public function update(UserUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $userId = auth()->user()->id;

        $user = User::findOrFail($userId);

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->updated_at = now();
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }
}
