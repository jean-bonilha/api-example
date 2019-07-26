<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class WorkstationController extends Controller
{
    public function __construct()
    {
        parent::__construct('Workstation');
        parent::setValidateFields([
            'nome' => 'required|string|min:2|max:255',
        ]);
    }
}
