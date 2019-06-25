<?php

namespace App\Traits;

use Auth;
use Validator;

trait ResourcesController
{
    private $model;
    private $jsonResource;
    private $resourceCollection;

    private $paginate;
    private $scope = 'Api';

    private $validateFields = [];

    public function __construct(string $model) {
        $this->model = $model;
        $this->jsonResource = $model . 'Resource';
        $this->resourceCollection = $model . 'Collection';
    }

    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;
    }

    public function getPaginate()
    {
        return $this->paginate;
    }

    public function setValidateFields($validateFields)
    {
        $this->validateFields = $validateFields;
    }

    public function getValidateFields()
    {
        return $this->validateFields;
    }

    protected function setResources()
    {
        $this->createModels();
        $this->createJsonResource();
        $this->createResourceCollection();
        return $this;
    }

    protected function createModels()
    {
        $model = $this->model;
        $modelPath = "App\\Models\\$model";
        $classExists = class_exists($modelPath);
        $this->Model = $classExists ? $modelPath : "App\\$model";
    }

    protected function createJsonResource()
    {
        $this->createResource($this->jsonResource, 'JsonResource');
    }

    protected function createResourceCollection()
    {
        $this->createResource($this->resourceCollection, 'ResourceCollection');
    }

    protected function createResource($resource, $property)
    {
        $scope = $this->scope;
        $v = config('app.api_version');
        $this->{$property} = "App\\Http\\Resources\\$scope\\v$v\\$resource";
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

    /**
     * Sets saved_user field on $data array with current user.
     *
     * @param  array  $data optional
     * @return array  $data modified
     */
    protected function setUserSave($data)
    {
        if (Auth::check()) {
            $data['saved_user'] = Auth::id();
        }
        return $data;
    }
}
