<?php

namespace App\Models;

class Company extends BaseModel
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
    protected $filterBy = 'razao_social';

    /**
     * The name of field for sort by
     *
     * @var string
     */
    protected $sortBy = 'razao_social';
}
