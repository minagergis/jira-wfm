<?php

namespace App\Modules\Tasks\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\Tasks\Repositories\TaskRepository;

class TaskService extends AbstractCoreService
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }
}
