<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\User;

class UserCollection extends ResourceCollection
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
                    'name' => $item->name,
                    'email' => $item->email,
                    'registered_by' => $item->registered_by ? User::find($item->registered_by)->name : 'AUTO CADASTRO',
                    'activated' => $item->activated ? 'ATIVADO' : 'DESATIVADO',
                    'form' => 'user-store',
                ];
            }),
        ];
    }
}
