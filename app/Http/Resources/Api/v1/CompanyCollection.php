<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\User;

class CompanyCollection extends ResourceCollection
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
                    'razao_social' => $item->razao_social,
                    'nome_fantasia' => $item->nome_fantasia,
                    'cnpj' => $item->cnpj,
                    'codigo_descricao' => $item->codigo_descricao,
                    'grau_risco' => $item->grau_risco,
                    'grupo_risco' => $item->grupo_risco,
                    'registered_by' => $item->registered_by ? User::find($item->registered_by)->name : 'AUTO CADASTRO',
                    'form' => 'company-form',
                ];
            }),
        ];
    }
}
