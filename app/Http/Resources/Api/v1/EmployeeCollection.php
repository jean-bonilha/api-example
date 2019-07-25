<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use App\Models\Company;
use App\Models\Person;
use App\Models\Sector;
use App\Models\Role;
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
                    'company_name' => Company::find($item->company_id)['razao_social'],
                    'person_id' => $item->person_id,
                    'person_name' => Person::find($item->person_id)['nome'],
                    'sector_id' => $item->sector_id,
                    'sector_name' => Sector::find($item->sector_id)['nome'],
                    'role_id' => $item->role_id,
                    'role_name' => Role::find($item->role_id)['nome'],
                    'registered_by' => $item->registered_by ? User::find($item->registered_by)['name'] : 'AUTO CADASTRO',
                ];
            }),
        ];
    }
}
