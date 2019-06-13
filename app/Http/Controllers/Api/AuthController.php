<?php

namespace App\Http\Controllers\Api;

use Hash;
use App\User;
use App\Http\Controllers\Firebase\FirebaseAuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class AuthController extends UserController
{
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
            if (!boolval($user->activated)) {
                $response = ['message' => 'User is not activated.'];
                return response($response, 202);
            }
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $properties = $user->toArray();
                $properties['password'] = $request->password;
                $firebaseUserSave = (new FirebaseAuthController)->store($properties);
                if (!$firebaseUserSave) {
                    return response()->json([
                        'message' => 'Save user on Firebase service failed.'
                    ]);
                }
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
        $user = $request->user();
        $token = $user->token();
        $token->revoke();
        $response = [];

        $firebaseUserSave = (new FirebaseAuthController)->destroyByEmail($user->email);
        if (!$firebaseUserSave) {
            $response['farebase'] = 'User logout on Firebase service failed.';
        }

        $response['message'] = 'You have been succesfully logged out!';
        return response($response, 200);
    }
}
