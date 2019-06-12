<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Http\Controllers\Firebase\FirebaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $validateFields = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateFields);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $firebaseUserSave = (new FirebaseAuthController)->store($request->all());

        if (!$firebaseUserSave) {
            return response()->json([
                'message' => 'Save user on Firebase service failed.'
            ]);
        }

        $request['password'] = Hash::make($request['password']);
        return User::create($request->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateFields = $this->validateFields;
        $validateFields['email'] = 'required|string|email|max:255';
        $validator = Validator::make($request->all(), $validateFields);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'User not exists.'
            ]);
        }

        $firebaseUserUpdate = (new FirebaseAuthController)->update($request->all(), $user->email);

        if (!$firebaseUserUpdate) {
            return response()->json([
                'message' => 'Update user on Firebase service failed.'
            ]);
        }

        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        }

        $updated = $user->update($request->toArray());

        if ($updated) {
            return response()->json([
                'message' => 'User updated successfully.'
            ]);
        }

        return response()->json([
            'message' => 'User update fail.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message' => 'User not exists.'
            ]);
        }

        (new FirebaseAuthController)->destroyByEmail($user->email);

        $deleted = $user->delete($id);

        if ($deleted) {
            return response()->json([
                'message' => 'Delete user failed.'
            ]);
        }

        return response()->json([
            'message' => 'User was deleted with successfully.'
        ]);
    }
}
