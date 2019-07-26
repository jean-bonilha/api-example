<?php

namespace App\Models\Logs;

use Jenssegers\Mongodb\Eloquent\Model;

class Workstation extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'workstations';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
