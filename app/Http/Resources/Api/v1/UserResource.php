<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'registered_by' => $this->registered_by,
            'registered_by_name' => $this->registered_by ? User::find($this->registered_by)['name'] : 'AUTO CADASTRO',
            'activated' => $this->activated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
