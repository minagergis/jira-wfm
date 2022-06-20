<?php

namespace App\Modules\Distribution\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\Distribution\Repositories\TaskDistributionLogRepository;

class TaskDistributionLogService extends AbstractCoreService
{
    protected $repository;

    public function __construct(TaskDistributionLogRepository $taskDistributionLogRepository)
    {
        $this->repository = $taskDistributionLogRepository;
    }
}
