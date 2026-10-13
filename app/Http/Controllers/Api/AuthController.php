<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:6',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' =>$request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 201);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'successfully',
            'message' => 'Logged out successfully'
        ]);
    }

    public function login(Request $request){
        $request->validate([
           'email' => 'required|email',
           'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->first();

        //cek user di dalam database user apa engga

        if (!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'email not found'
            ], 401);
        }
        
        //cek password
        if (!Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'password not match'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 200);
    }
}