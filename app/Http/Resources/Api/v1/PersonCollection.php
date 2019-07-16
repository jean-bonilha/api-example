<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'nome' => $item->nome,
                    'rg' => $item->rg,
                    'data_nascimento' => $item->data_nascimento,
                    'sexo' => $item->sexo,
                    'rg_orgao_uf_emissao' => $item->rg_orgao_uf_emissao,
                    'rg_data_expedicao' => $item->rg_data_expedicao,
                    'cpf' => $item->cpf,
                    'cnh' => $item->cnh,
                    'cnh_categoria' => $item->cnh_categoria,
                    'nis' => $item->nis,
                    'raca_cor' => $item->raca_cor,
                    'estado_civil' => $item->estado_civil,
                    'grau_instrucao' => $item->grau_instrucao,
                    'nome_social' => $item->nome_social,
                    'minicipio' => $item->minicipio,
                    'uf' => $item->uf,
                    'codigo_pais_nascimento' => $item->codigo_pais_nascimento,
                    'nome_mae' => $item->nome_mae,
                    'nome_pai' => $item->nome_pai,
                    'ctps_numero' => $item->ctps_numero,
                    'ctps_serie' => $item->ctps_serie,
                    'registered_by' => $item->registered_by ? User::find($item->registered_by)->name : 'AUTO CADASTRO',
                ];
            }),
        ];
    }
}
