<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct('Role');
        parent::setValidateFields([
            'nome' => 'required|string|min:3|max:255',
        ]);
    }
}
