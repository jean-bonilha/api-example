<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'nome' => $this->nome,
            'rg' => $this->rg,
            'data_nascimento' => $this->data_nascimento,
            'sexo' => $this->sexo,
            'rg_orgao_uf_emissao' => $this->rg_orgao_uf_emissao,
            'rg_data_expedicao' => $this->rg_data_expedicao,
            'cpf' => $this->cpf,
            'cnh' => $this->cnh,
            'cnh_categoria' => $this->cnh_categoria,
            'nis' => $this->nis,
            'raca_cor' => $this->raca_cor,
            'estado_civil' => $this->estado_civil,
            'grau_instrucao' => $this->grau_instrucao,
            'nome_social' => $this->nome_social,
            'condigo_minicipio' => $this->condigo_minicipio,
            'sigla_uf' => $this->sigla_uf,
            'codigo_pais_nascimento' => $this->codigo_pais_nascimento,
            'nome_mae' => $this->nome_mae,
            'nome_pai' => $this->nome_pai,
            'ctps_numero' => $this->ctps_numero,
            'ctps_serie' => $this->ctps_serie,
            'registered_by' => $this->registered_by,
            'registered_by_name' => $this->registered_by ? User::find($this->registered_by)->name : 'AUTO CADASTRO',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
