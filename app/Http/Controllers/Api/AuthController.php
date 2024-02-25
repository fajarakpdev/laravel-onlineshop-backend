<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users|max:100',
            'password' => 'required',
            'phone' => 'required',
            'roles' => 'required',
        ]);

        //password encryption
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 201);
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Berhasil'
        ], 200);
    }

    //login
    public function login(Request $request)
    {
        //validate the request
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        //versi advance
        // if (!$user || !Hash::check($validated['password'], $user->password)) {
        //     return response()->json([
        //         'message' => 'Bad Credential',
        //     ], 401);
        // }

        //versi simple
        if (!Hash::check($validated['password'], $user->password)){
            return response()->json([
                'message' => 'invalid passowrd',
            ],401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user
        ], 200);
    }
}
