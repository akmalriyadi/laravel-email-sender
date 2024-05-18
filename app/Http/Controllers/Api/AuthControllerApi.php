<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthControllerApi extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $auth = Auth::user();
            $shareAuth = Auth::user()->makeHidden('id');

            $data = [
                'token_app' => $auth->createToken('auth_token')->plainTextToken,
                'authUser' => $shareAuth
            ];
            return response()->json([
                'status' => true,
                'code' => 200,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => 'Username / password invalid'
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'status' => true,
            'code' => 200,
            'data' => ''
        ], 200);
    }
}
