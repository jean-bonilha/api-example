<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Makes log from specific MySQL Model to equivalent collection.
     *
     * @param  string  $action (update|delete)
     * @return $this
     */
    public function makeLog($action = 'update')
    {
        $dataLog = $this->toArray();
        $dataLog['action'] = $action;
        $className = class_basename($this);
        $logClass = __NAMESPACE__ . '\\Logs\\' . $className;
        (new $logClass)::create($dataLog);
        return $this;
    }
}
