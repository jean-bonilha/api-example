<?php

namespace App\Http\Controllers\Api;

use Hash;
use App\Http\Controllers\BaseController as Controller;
use App\Http\Controllers\Firebase\FirebaseAuthController;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct('User');
        parent::setValidateFields([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['password'] === $request['password_confirmation']) {
            $hashPassword = Hash::make($request['password']);
            $request['password'] = $hashPassword;
            $request['password_confirmation'] = $hashPassword;
        }

        $this->setResources();

        $user = $this->Model::where(['email' => $request->email])->first();

        if ($user) {
            return new $this->JsonResource($user);
        }

        return parent::store($request);
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
        $this->setResources();

        $user = $this->Model::find($id);

        try {
            (new FirebaseAuthController)->update($request->all(), $user->email);
        } catch (\Throwable $th) { }

        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        }

        return parent::update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->setResources();

        $user = $this->Model::find($id);

        if ($user) {
            try {
                (new FirebaseAuthController)->destroyByEmail($user->email);
            } catch (\Throwable $th) {
                return $this->unprocessable($th->getMessage());
            }
        } else {
            return $this->notFound();
        }

        return parent::destroy($id);
    }
}
