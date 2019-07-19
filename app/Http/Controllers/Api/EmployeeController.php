<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class EmployeeController extends Controller
{
    public function __construct()
    {
        parent::__construct('Employee');
        parent::setValidateFields([
            'company_id' => 'integer',
            'person_id' => 'integer',
            'sector_id' => 'integer',
            'role_id' => 'integer',
            'registered_by' => 'integer',
        ]);
    }
}
