<?php

namespace App\Http\Controllers\Api;

use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class AuthController extends UserController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function register(Request $request)
    {
        $storeResponse = $this->store($request);

        if (gettype($storeResponse) === 'array') {
            $response = ['errors' => $storeResponse];
            return response($response, 422);
        }

        $token = $storeResponse->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ['message' => 'Password missmatch'];
                return response($response, 422);
            }
        } else {
            $response = ['message' => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = ['message' => 'You have been succesfully logged out!'];
        return response($response, 200);
    }
}
