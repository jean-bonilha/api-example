<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;

class CompanyController extends Controller
{
    public function __construct()
    {
        parent::__construct('Company', 'CompanyResource', 'CompanyCollection');
        parent::setPaginate(10);
        parent::setValidateFields([
            'razao_social' => 'string|min:3|max:255',
            'nome_fantasia' => 'string|min:3|max:255',
            'cnpj' => 'string|min:18|max:18',
            'codigo_descricao' => 'string|min:3',
            'grau_risco' => 'string|min:2|max:2',
            'grupo_risco' => 'string|min:5|max:5',
        ]);
    }
}
