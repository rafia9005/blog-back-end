<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ]);
        }

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
            "type" => "Bearer",
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'member';
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully registered',
        ], 201);
    }
}
