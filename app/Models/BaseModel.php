<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Makes log from specific MySQL Model to equivalent collection.
     *
     * @param  string  $action (update|delete)
     * @return $this
     */
    public function makeLog($action = 'updated')
    {
        $dataLog = $this->toArray();
        $dataLog['action'] = $action;
        $className = class_basename($this);
        $logClass = __NAMESPACE__ . '\\Logs\\' . $className;
        (new $logClass)::create($dataLog);
        return $this;
    }

    public function removeLog()
    {
        $table = $this->table;
        $itemDelete = DB::connection('mongodb')
            ->collection($table)
            ->orderBy('created_at', 'desc')
            ->first();

        DB::connection('mongodb')
            ->collection($table)
            ->where('_id', $itemDelete['_id'])
            ->delete();

        return $this;
    }
}
