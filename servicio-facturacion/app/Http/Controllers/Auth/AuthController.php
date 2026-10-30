<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Summary of login
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token');
           
            return response()->json([
                'user' => $user->only(['name', 'email']),
                'token' => $token->plainTextToken,
                'token_created_at' => $token->accessToken->created_at,
                'token_expires_at' => $token->accessToken->expires_at,
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }
}
