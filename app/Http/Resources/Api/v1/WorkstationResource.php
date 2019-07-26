<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkstationResource extends JsonResource
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
            'registered_by_name' => $this->registered_by ? User::find($this->registered_by)['name'] : 'AUTO CADASTRO',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
