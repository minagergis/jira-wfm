<?php

namespace App\Modules\Core\Repositories;

abstract class AbstractCoreRepository
{
    protected $model;

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function all()
    {
        return $this->model->get();
    }

    public function withScope($scopeName, $args = null)
    {
        if ($args) {
            return $this->model->{$scopeName}($args)->get();
        }

        return $this->model->{$scopeName}()->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findWithConditions(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }

    public function allWithConditions(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }

    public function update($id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function query()
    {
        return $this->model->newQuery();
    }
}
