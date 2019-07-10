<?php

namespace App\Http\Resources\Api\v1;
use App\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'nome_fantasia' => $this->nome_fantasia,
            'cnpj' => $this->cnpj,
            'codigo_descricao' => $this->codigo_descricao,
            'grau_risco' => $this->grau_risco,
            'grupo_risco' => $this->grupo_risco,
            'registered_by' => $this->registered_by,
            'registered_by_name' => $this->registered_by ? User::find($this->registered_by)->name : 'AUTO CADASTRO',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
