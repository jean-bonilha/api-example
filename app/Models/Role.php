<?php

namespace App\Models;

class Role extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'registered_by',];

    /**
     * The name of field for filter
     *
     * @var string
     */
    protected $filterBy = 'nome';
}
