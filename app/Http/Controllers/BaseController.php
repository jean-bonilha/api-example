<?php

namespace App\Http\Controllers;

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
        $validateFields = $this->getValidateFields();
        $validator = Validator::make($request->all(), $validateFields);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $this->setResources();
        try {
            return response()->json([
                'message' => $this->Model::create($request->all())
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
        $validateFields = $this->getValidateFields();
        $validator = Validator::make($request->all(), $validateFields);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $this->setResources();
        try {
            $itemUpdate = $this->Model::find($id);
            return response()->json([
                'message' => $itemUpdate->update($request->all())
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
                'message' => $this->Model::find($id)->delete()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 422);
        }
    }
}
