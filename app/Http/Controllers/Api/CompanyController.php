<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class CompanyController extends Controller
{
    public function __construct()
    {
        parent::__construct('Company');
        parent::setPaginate(10);
        parent::setValidateFields([
            'razao_social' => 'required|string|min:3|max:255',
            'nome_fantasia' => 'required|string|min:3|max:255',
            'cnpj' => 'required|string|min:18|max:18|unique:companies',
            'codigo_descricao' => 'string|min:3',
            'grau_risco' => 'string|min:2|max:2',
            'grupo_risco' => 'string|min:5|max:5',
            'saved_user' => 'integer',
        ]);
    }
}
