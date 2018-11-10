<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    /**
     * Login user and create access token
     * @param [string] email
     * @param [string] password
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('AuthorizationToken');
        $token = $tokenResult->token;

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at
        ]);
    }

    public function register(Request $request) {
        $alidator = Validator::make([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->error()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token = $user->createToken('AuthorizationToken');
        
        return respone()->json([
            'access_token' => $token->accesstoken,
            'token_type' => 'Bearer',
            'expires_at' => $token->token->expires_at,
            'user' => $user
        ]);
    }

    public function me() {
        $user = Auth::user();

        return response()->json($user, 200);
    }
}
