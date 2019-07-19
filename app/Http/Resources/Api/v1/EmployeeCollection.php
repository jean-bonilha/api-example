<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeCollection extends ResourceCollection
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
                    'company_id' => $item->company_id,
                    'person_id' => $item->person_id,
                    'sector_id' => $item->sector_id,
                    'role_id' => $item->role_id,
                    'registered_by' => $item->registered_by ? User::find($item->registered_by)['name'] : 'AUTO CADASTRO',
                ];
            }),
        ];
    }
}
