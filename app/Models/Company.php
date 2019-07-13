<?php

namespace App\Models;

class Company extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'codigo_descricao',
        'grau_risco',
        'grupo_risco',
        'registered_by',
    ];

    /**
     * The name of field for filter
     *
     * @var string
     */
    protected $filterBy = 'razao_social';

    /**
     * The name of field for sort by
     *
     * @var string
     */
    protected $sortBy = 'razao_social';
}
