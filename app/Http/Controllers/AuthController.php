<?php

namespace App\Http\Controllers;

use App\Models\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = UserService::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        return response()->json(['message' => 'User registered', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $user = UserService::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}

