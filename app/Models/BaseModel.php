<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The name of field for filter by
     *
     * @var string
     */
    protected $filterBy = '';

    /**
     * The name of field for sort by
     *
     * @var string
     */
    protected $sortBy = '';

    /**
     * Get the filterBy associated with the model.
     *
     * @return string
     */
    public function getFilterBy()
    {
        return $this->filterBy;
    }

    /**
     * Set the filterBy associated with the model.
     *
     * @param  string  $filterBy
     * @return $this
     */
    public function setFilterBy($filterBy)
    {
        $this->filterBy = $filterBy;
    }

    /**
     * Get the sortBy associated with the model.
     *
     * @return string
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * Set the sortBy associated with the model.
     *
     * @param  string  $sortBy
     * @return $this
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }

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
