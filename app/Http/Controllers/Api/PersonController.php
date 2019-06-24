<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use App\Http\Controllers\BaseController as Controller;

class PersonController extends Controller
{
    public function __construct()
    {
        parent::__construct('Person');
        parent::setPaginate(10);

        $birthValidations = 'required|date|date_format:Y-m-d|before:now|after:-110 years';
        parent::setValidateFields([
            'nome' => 'required|string|min:3|max:255',
            'rg' => 'required|string|min:3|max:255',
            'data_nascimento' => $birthValidations,
            'sexo' => ['required', Rule::in(['M', 'F', 'T', 'O'])],
            'rg_orgao_uf_emissao' => 'string|min:3|max:255',
            'rg_data_expedicao' => 'string|min:3|max:255',
            'cpf' => 'string|min:11|max:11',
            'cnh' => 'string|min:3|max:255',
            'cnh_categoria' => 'string|min:3|max:255',
            'nis' => 'string|min:3|max:255',
            'raca_cor' => 'string|min:3|max:255',
            'estado_civil' => 'string|min:3|max:255',
            'grau_instrucao' => 'string|min:3|max:255',
            'nome_social' => 'string|min:3|max:255',
            'minicipio' => 'string|min:3|max:255',
            'uf' => 'string|min:2|max:2',
            'codigo_pais_nascimento' => 'string|min:3|max:255',
            'nome_mae' => 'string|min:3|max:255',
            'nome_pai' => 'string|min:3|max:255',
            'ctps_numero' => 'string|min:3|max:255',
            'ctps_serie' => 'string|min:3|max:255',
            'saved_user' => 'integer',
        ]);
    }
}
