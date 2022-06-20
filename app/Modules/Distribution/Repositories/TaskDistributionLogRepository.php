<?php

namespace App\Modules\Distribution\Repositories;

use App\Modules\Core\Repositories\AbstractCoreRepository;
use App\Modules\Distribution\Entities\TaskDistributionLog;

class TaskDistributionLogRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(TaskDistributionLog $model)
    {
        $this->model = $model;
    }
}
