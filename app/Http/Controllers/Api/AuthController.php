<?php

namespace App\Http\Controllers\Api;

use Hash;
use App\User;
use App\Http\Controllers\Firebase\FirebaseAuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;

class AuthController extends UserController
{
    public function register(Request $request)
    {
        $storeResponse = $this->store($request);

        if (class_basename($storeResponse) === 'MessageBag') {
            $response = ['errors' => $storeResponse];
            return response($response, 422);
        }

        $response = ['message' => 'User created successfully!'];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!boolval($user->activated)) {
                return response()->json([
                    'errors' => ['message' => 'User is not activated.']
                ], 422);
            }
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $properties = $user->toArray();
                $properties['password'] = $request->password;
                $firebaseUserSave = (new FirebaseAuthController)->store($properties);
                if (!$firebaseUserSave) {
                    return response()->json([
                        'errors' => ['message' => 'Save user on Firebase service failed.']
                    ], 422);
                }
                $response = ['token' => $token];
                return response($response, 201);
            } else {
                return response()->json([
                    'errors' => ['message' => 'Password missmatch.']
                ], 422);
            }
        } else {
            return response()->json([
                'errors' => ['message' => 'User does not exist.']
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $firebaseUserSave = (new FirebaseAuthController)->destroyByEmail($user->email);

        if (!$firebaseUserSave) {
            return response()->json([
                'errors' => ['message' => 'User logout on Firebase service failed.']
            ], 422);
        }

        $token = $user->token();
        $token->revoke();

        return response()->json([
            'errors' => ['message' => 'You have been succesfully logged out!']
        ], 200);
    }
}
