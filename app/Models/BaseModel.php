<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function makeLog()
    {
        $dataLog = $this->toArray();
        $className = class_basename($this);
        $logClass = __NAMESPACE__ . '\\Logs\\' . $className;
        (new $logClass)::create($dataLog);
        return $this;
    }
}
