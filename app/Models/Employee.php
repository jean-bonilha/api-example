<?php

namespace App\Models;

class Employee extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'person_id',
        'sector_id',
        'role_id',
        'registered_by',
    ];

    /**
     * The name of field for filter
     *
     * @var string
     */
    protected $filterBy = 'company_id';
}
