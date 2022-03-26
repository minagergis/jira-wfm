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

    public function withScope($scopeName)
    {
        return $this->model->$scopeName()->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
