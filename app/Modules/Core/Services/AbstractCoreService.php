<?php

namespace App\Modules\Core\Services;

abstract class AbstractCoreService
{
    protected $repository;

    public function index()
    {
        return $this->repository->all();
    }

    public function create($attributes)
    {
        return $this->repository->create($attributes);
    }

    public function read($id)
    {
        return $this->repository->find($id);
    }

    public function update($attributes, $id)
    {
        return $this->repository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function withScope($scopeName)
    {
        return $this->repository->withScope($scopeName);
    }
}
