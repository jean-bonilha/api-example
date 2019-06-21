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
        return new $this->JsonResource(
            $this->Model::find($id)
        );
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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $this->setResources();
        $dataUpdate = $this->setUserSave($request->all());
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->setResources();
        try {
            return response()->json([
                'message' => $this->Model::find($id)->makeLog('deleted')->delete()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 422);
        }
    }

    /**
     * Make validation in array $requestAll.
     *
     * @param  array  $requestAll
     * @return \Illuminate\Support\Facades\Validator
     */
    protected function validator($requestAll, $insert = false)
    {
        $validateFields = $this->getValidateFields();
        $addRequired = function ($v) {
            return "required|$v";
        };
        if ($insert) {
            $validateFields = array_map($addRequired, $validateFields);
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
