<?php

namespace App\Traits;

use Auth;
use Validator;

trait ResourcesController
{
    private $model;
    private $jsonResource;
    private $resourceCollection;
    private $scope = 'Api';

    private $validateFields = [];

    public function __construct(string $model = null) {
        $this->model = $model;
        $this->jsonResource = $model . 'Resource';
        $this->resourceCollection = $model . 'Collection';
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
        if (!isset($this->Model)) {
            $model = $this->model;
            $modelPath = "App\\Models\\$model";
            $classExists = class_exists($modelPath);
            $this->Model = $classExists ? $modelPath : "App\\$model";
        }
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
        if (!isset($this->{$property})) {
            $scope = $this->scope;
            $v = config('app.api_version');
            $this->{$property} = "App\\Http\\Resources\\$scope\\v$v\\$resource";
        }
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
     * Sets registered_by field on $data array with current user.
     *
     * @param  array  $data optional
     * @return array  $data modified
     */
    protected function setUserSave($data)
    {
        if (Auth::check()) {
            $data['registered_by'] = Auth::id();
        }
        return $data;
    }
}
