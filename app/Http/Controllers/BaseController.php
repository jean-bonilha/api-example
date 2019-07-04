<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResourcesController;
use App\Traits\ResponseController;
use Illuminate\Support\Facades\Input;

abstract class BaseController extends Controller
{
    use ResourcesController, ResponseController;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setResources();

        $filter = Input::get('filter');

        if (!$filter) {
            return new $this->ResourceCollection(
                $this->Model::paginate()
            );
        }

        $filterBy = (new $this->Model)->getFilterBy();

        return new $this->ResourceCollection(
            $this->Model::where("$filterBy", 'like', "%$filter%")->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\BaseModel
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->unprocessable($validator->errors());
        }

        $dataStore = $this->setResources()->setUserSave($request->all());

        $resource = $this->Model::create($dataStore);

        if ($resource) {
            return new $this->JsonResource(
                $resource
            );
        }

        return $this->unprocessable();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->setResources();
        $resource = $this->Model::find($id);
        if ($resource) {
            return new $this->JsonResource(
                $resource
            );
        }
        return $this->notFound();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all(), true);

        if ($validator->fails()) {
            return $this->unprocessable($validator->errors());
        }

        $this->setResources();

        $dataUpdate = $this->setUserSave($request->all());
        $itemUpdate = $this->Model::find($id);

        if ($itemUpdate) {
            try {
                $updated = $this->Model::find($id)->makeLog()->update($dataUpdate);
                if ($updated) {
                    return new $this->JsonResource(
                        $this->Model::find($id)
                    );
                }
                return $this->unprocessable($th->getMessage());
            } catch (\Throwable $th) {
                return $this->unprocessable($th->getMessage());
            }
        }

        return $this->notFound();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->setResources();

        $itemDelete = $this->Model::find($id);

        if ($itemDelete) {
            try {
                $itemDelete->makeLog('deleted')->delete();
            } catch (\Throwable $th) {
                $itemDelete->removeLog();
                return $this->unprocessable($th->getMessage());
            }

            return $this->success();
        }

        return $this->notFound();
    }
}
