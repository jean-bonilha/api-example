<?php

namespace App\Models\Logs;

use Jenssegers\Mongodb\Eloquent\Model;

class Sector extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'sectors';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
