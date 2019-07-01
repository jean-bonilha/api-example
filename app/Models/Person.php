<?php

namespace App\Models;

class Person extends BaseModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The name of field for filter
     *
     * @var string
     */
    protected $filterBy = 'nome';
}
