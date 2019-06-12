<?php

namespace App\Http\Controllers\Firebase;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use App\Http\Controllers\Controller;

class FirebaseController extends Controller
{
    const pathOfCredentials = '/app/firebase/credentials.json';

    private $serviceAccount;

    public function __construct()
    {
        $fullPathOfCredentials = $this->getFullPathOfCredentials();
        $this->serviceAccount = ServiceAccount::fromJsonFile($fullPathOfCredentials);
    }

    private function getFullPathOfCredentials()
    {
        return \storage_path() . self::pathOfCredentials;
    }

    public function getAuth()
    {
        $firebase = (new Factory)
            ->withServiceAccount($this->serviceAccount)
            ->create();

        return $firebase->getAuth();
    }

    public function getDatabase()
    {
        $firebase = (new Firebase\Factory())
            ->withServiceAccount($this->serviceAccount)
            ->create();
        return $firebase->getDatabase();
    }
}
