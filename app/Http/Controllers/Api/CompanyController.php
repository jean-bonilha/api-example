<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class CompanyController extends Controller
{
    public function __construct()
    {
        parent::__construct('Company', 'CompanyResource', 'CompanyCollection', 10);
    }
}
