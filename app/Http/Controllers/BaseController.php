<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResourcesController;

abstract class BaseController extends Controller
{
    use ResourcesController;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setResources();

        $paginate = $this->paginate;

        if ($paginate) {
            return new $this->ResourceCollection(
                $this->Model::paginate($paginate)
            );
        }

        return new $this->ResourceCollection(
            $this->JsonResource::collection(
                $this->Model::all()
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
            return $validator->errors();
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
        return response()->json([
            'errors' => ['message' => 'Resource not found.']
        ], 404);
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
            return response()->json([
                'errors' => ['message' => $validator->errors()]
            ], 422);
        }

        $this->setResources();

        $dataUpdate = $this->setUserSave($request->all());
        $itemUpdate = $this->Model::find($id);

        if ($itemUpdate) {
            try {
                $this->Model::find($id)->makeLog()->update($dataUpdate);
                return response()->json([
                    'message' => 'User successfully updated!'
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'errors' => ['message' => $th->getMessage()]
                ], 422);
            }
        }

        return response()->json([
            'errors' => ['message' => 'Resource not found.']
        ], 404);
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
                return response()->json([
                    'errors' => ['message' => 'Resource not deleted.']
                ], 422);
            }

            return response()->json([
                'message' => 'User deleted successfully!'
            ], 200);
        }

        return response()->json([
            'errors' => ['message' => 'Resource not found.']
        ], 404);
    }
}
