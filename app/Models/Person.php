<?php

namespace App\Models;

class Person extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'rg',
        'data_nascimento',
        'sexo',
        'rg_orgao_uf_emissao',
        'rg_data_expedicao',
        'cpf',
        'cnh',
        'cnh_categoria',
        'nis',
        'raca_cor',
        'estado_civil',
        'grau_instrucao',
        'nome_social',
        'minicipio',
        'uf',
        'codigo_pais_nascimento',
        'nome_mae',
        'nome_pai',
        'ctps_numero',
        'ctps_serie',
        'registered_by',
    ];

    /**
     * The name of field for filter
     *
     * @var string
     */
    protected $filterBy = 'nome';
}
