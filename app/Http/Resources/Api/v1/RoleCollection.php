<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
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
                    'registered_by' => $item->registered_by ? User::find($item->registered_by)['name'] : 'AUTO CADASTRO',
                ];
            }),
        ];
    }
}
