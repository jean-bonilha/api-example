<?php

namespace App\Models\Logs;

use Jenssegers\Mongodb\Eloquent\Model;

class Person extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'people';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
