<?php

namespace App\Http\Controllers\Firebase;

class FirebaseAuthController extends FirebaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = [];

        $users = $this->getAuth()->listUsers();

        foreach ($users as $user) {
            array_push($userList, $user);
        }

        return $userList;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $properties
     * @return \Illuminate\Http\Response
     */
    public function store($properties)
    {
        $removeKey = ['id', 'password_confirmation', 'created_at', 'updated_at', 'email_verified_at'];

        for ($i=0; $i < count($removeKey); $i++) {
            if (array_key_exists($removeKey[$i], $properties)) {
                unset($properties[$removeKey[$i]]);
            }
        }

        if (isset($properties['name'])) {
            $properties['displayName'] = $properties['name'];
            unset($properties['name']);
        }

        try {
            return
            boolval($this
                ->destroyByEmail($properties['email'])
                ->getAuth()
                ->createUser($properties));
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getAuth()->getUser($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function showByEmail($email)
    {
        return $this->getAuth()->getUserByEmail($email);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $properties
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($properties, $email)
    {
        $removeKey = ['id', 'email', 'password_confirmation'];

        for ($i=0; $i < count($removeKey); $i++) {
            if (array_key_exists($removeKey[$i], $properties)) {
                unset($properties[$removeKey[$i]]);
            }
        }

        if (isset($properties['name'])) {
            $properties['displayName'] = $properties['name'];
            unset($properties['name']);
        }

        $user = $this->showByEmail($email);
        return $this->getAuth()->updateUser($user->uid, $properties);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->getAuth()->deleteUser($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $email
     * @return boolean TRUE|FALSE
     */
    public function destroyByEmail($email)
    {
        try {
            $uid = $this->showByEmail($email)->uid;
        } catch (\Throwable $th) {

        }

        try {
            $this->destroy($uid);
        } catch (\Throwable $th) {

        }

        try {
            $db = $this->getDatabase();
            $db->getReference('users_oneline/'.$uid)->remove();
        } catch (\Throwable $th) {

        }

        return $this;
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        return $this->getAuth()->disableUser($id);
    }

    /**
     * Enable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enable($id)
    {
        return $this->getAuth()->enableUser($id);
    }
}
