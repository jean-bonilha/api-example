<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\BaseController as Controller;

class EmployeeController extends Controller
{
    public function __construct()
    {
        parent::__construct('Employee');
        parent::setValidateFields([
            'company_id' => 'integer',
            'person_id' => 'integer',
            'sector_id' => 'integer',
            'role_id' => 'integer',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setResources();

        $modelResource = new $this->Model;

        $filter = Input::get('filter');

        $perPage = Input::get('per_page');

        $sort = Input::get('sort');

        if ($perPage) $modelResource->setPerPage($perPage);

        $filterBy = $modelResource->getFilterBy();

        $sortBy = $modelResource->getSortBy() ?: $filterBy;

        $sort = $sort ? explode('|', $sort) : [$sortBy, 'asc'];

        if (!$filter) {
            return new $this->ResourceCollection(
                $modelResource::orderBy($sort[0], $sort[1])->paginate()
            );
        }

        $filter = DB::table('companies')->where('razao_social', 'like', "%$filter%")->first()->id;

        return new $this->ResourceCollection(
            $modelResource::where("$filterBy", "$filter")
                ->orderBy($sort[0], $sort[1])
                ->paginate()
        );
    }
}
