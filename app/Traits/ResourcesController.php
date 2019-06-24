<?php

namespace App\Traits;

use Auth;

trait ResourcesController
{
    private $model;
    private $jsonResource;
    private $resourceCollection;

    private $paginate;
    private $scope = 'Api';

    private $validateFields = [];

    public function __construct(
        string $model,
        string $jsonResource,
        string $resourceCollection
    ) {
        $this->model = $model;
        $this->jsonResource = $jsonResource;
        $this->resourceCollection = $resourceCollection;
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
        $this->setModels();
        $this->defineJsonResource();
        $this->defineResourceCollection();
    }

    protected function setModels()
    {
        $model = $this->model;
        $this->Model = "App\\Models\\$model";
    }

    protected function defineJsonResource()
    {
        $this->defineResource($this->jsonResource, 'JsonResource');
    }

    protected function defineResourceCollection()
    {
        $this->defineResource($this->resourceCollection, 'ResourceCollection');
    }

    protected function defineResource($resource, $property)
    {
        $scope = $this->scope;
        $v = config('app.api_version');
        $this->{$property} = "App\\Http\\Resources\\$scope\\v$v\\$resource";
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
