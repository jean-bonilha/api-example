<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use App\Http\Controllers\BaseController as Controller;

class PersonController extends Controller
{
    public function __construct()
    {
        parent::__construct('Person', 'PersonResource', 'PersonCollection');
        parent::setPaginate(10);
        parent::setValidateFields([
            'nome' => 'string|min:3|max:255',
            'rg' => 'string|min:3|max:255',
            'data_nascimento' => 'date',
            'sexo' => Rule::in(['M', 'F', 'T', 'O']),
        ]);
    }
}
