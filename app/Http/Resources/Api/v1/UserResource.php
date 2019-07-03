<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'registered_by' => $this->registered_by ? User::find($this->registered_by)->name : 'AUTO CADASTRO',
            'activated' => $this->activated ? 'ATIVADO' : 'DESATIVADO',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
