<?php

namespace App\Modules\Tasks\Repositories;

use App\Modules\Core\Repositories\AbstractCoreRepository;
use App\Modules\Tasks\Entities\Task;

class TaskRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(Task $task)
    {
        $this->model = $task;
    }
}
