<?php

namespace App\Http\Resources\Api\v1;

use App\User;
use App\Models\Company;
use App\Models\Person;
use App\Models\Sector;
use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'company_id' => $this->company_id,
            'company_name' => Company::find($this->company_id)['razao_social'],
            'person_id' => $this->person_id,
            'person_name' => Person::find($this->person_id)['nome'],
            'sector_id' => $this->sector_id,
            'sector_name' => Sector::find($this->sector_id)['nome'],
            'role_id' => $this->role_id,
            'role_name' => Role::find($this->role_id)['nome'],
            'registered_by' => $this->registered_by,
            'registered_by_name' => $this->registered_by ? User::find($this->registered_by)['name'] : 'AUTO CADASTRO',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
