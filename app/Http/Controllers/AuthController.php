<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $cr = $request->only('email', 'password');

        if (!Auth::attempt($cr)) {
            $user = User::where('email', $request->email)->first();
            $errorMessage = $user ? 'password wrong' : 'email not registered';
            return response()->json([
                "message" => $errorMessage
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "status" => true,
            "token" => $token,
            "type" => "Bearer"
        ], 200);
    }
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'member';
        $user->password = bcrypt($request->password);

        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }
    public function logout(Request $request)
    {
        $acces_token = $request->bearerToken();
        $token = PersonalAccessToken::findToken($acces_token);
        $token->delete();

        return response()->json([
            'status' => 'succes',
            'message' => 'Logout is succes!'
        ]);
    }
}
