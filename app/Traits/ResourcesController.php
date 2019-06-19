<?php

namespace App\Traits;

trait ResourcesController
{
    private $model;
    private $jsonResource;
    private $resourceCollection;

    private $paginate;
    private $scope = 'Api';

    public function __construct(
        string $model,
        string $jsonResource,
        string $resourceCollection,
        int $paginate = null
    ) {
        $this->model = $model;
        $this->jsonResource = $jsonResource;
        $this->resourceCollection = $resourceCollection;
        $this->paginate = $paginate;
    }

    protected function setResources()
    {
        $this->setModel();
        $this->defineJsonResource();
        $this->defineResourceCollection();
    }

    protected function setModel()
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
}
