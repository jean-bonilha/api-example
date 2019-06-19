<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class PersonController extends Controller
{
    public function __construct()
    {
        parent::__construct('Person', 'PersonResource', 'PersonCollection', 10);
    }
}
