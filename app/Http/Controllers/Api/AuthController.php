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

        if (class_basename($storeResponse) === 'JsonResponse') {
            return $storeResponse;
        }

        return $this->created(trans('auth.created'));
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!boolval($user->activated)) {
                return $this->unprocessable(trans('auth.no-activated'));
            }
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $properties = $user->toArray();
                $properties['password'] = $request->password;
                $firebaseUserSave = (new FirebaseAuthController)->store($properties);
                if (!$firebaseUserSave) {
                    return $this->unprocessable(trans('auth.firebase-save-failed'));
                }
                $response = ['token' => $token];
                return $this->created($response);
            } else {
                return $this->unprocessable(trans('auth.password-missmatch'));
            }
        } else {
            return $this->unprocessable(trans('auth.user-not-found'));
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $firebaseUserSave = (new FirebaseAuthController)->destroyByEmail($user->email);

        if (!$firebaseUserSave) {
            return $this->unprocessable(trans('auth.firebase-login-failed'));
        }

        $token = $user->token();
        $token->revoke();

        return $this->success(trans('auth.login-success'));
    }
}
