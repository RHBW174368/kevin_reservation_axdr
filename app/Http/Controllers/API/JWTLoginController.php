<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Http\Controllers\API\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Validator;

class JWTLoginController extends Controller
{
    public function login(Request $request)
    {
    	$credentials = $request->only('email', 'password');

        // Validations
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        // Return Error If Not Valid Request
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // If Valid Generate Token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Could not create token.',
                ], 500);
        }
    
        // Return Token Generated 
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
