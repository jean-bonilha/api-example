<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $this->setResources();
        $dataStore = $this->setUserSave($request->all());
        try {
            return response()->json([
                'message' => $this->Model::create($dataStore)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 422);
        }
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
                $this->Model::find($id)
            );
        }
        return response()->json([
            'message' => 'Resource not found.'
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
                'message' => $validator->errors()
            ], 422);
        }

        $this->setResources();

        $dataUpdate = $this->setUserSave($request->all());
        $itemUpdate = $this->Model::find($id);

        if ($itemUpdate) {
            try {
                $itemUpdate = $this->Model::find($id)->makeLog();
                return response()->json([
                    'message' => $itemUpdate->update($dataUpdate)
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => $th->getMessage()
                ], 422);
            }
        }

        return response()->json([
            'message' => 'Resource not found.'
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
                return response()->json([
                    'message' => $itemDelete->makeLog('deleted')->delete()
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => $th->getMessage()
                ], 422);
            }
        }
        return response()->json([
            'message' => 'Resource not found.'
        ], 404);
    }

    /**
     * Make validation in array $requestAll.
     *
     * @param  array  $requestAll
     * @param  boolean  $update optional
     * @return \Illuminate\Support\Facades\Validator
     */
    protected function validator($requestAll, $update = false)
    {
        $validateFields = $this->getValidateFields();
        $removeRequired = function ($validations) {
            return str_replace('required|', '', $validations);
        };
        if ($update) {
            $validateFields = array_map($removeRequired, $validateFields);
        }
        return Validator::make($requestAll, $validateFields);
    }

    protected function setUserSave($data)
    {
        if (Auth::check()) {
            $data['saved_user'] = Auth::id();
        }
        return $data;
    }
}
