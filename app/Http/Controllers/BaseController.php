<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResourcesController;
use App\Traits\ResponseController;

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

        $model = new $this->Model;

        $paginate = $model->getPerPage();

        if ($paginate) {
            return new $this->ResourceCollection(
                $model::paginate($paginate)
            );
        }

        return new $this->ResourceCollection(
            $this->JsonResource::collection(
                $model::all()
            )
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

        return $this->Model::create($dataStore);
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
                $this->Model::find($id)->makeLog()->update($dataUpdate);
                return $this->success();
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
