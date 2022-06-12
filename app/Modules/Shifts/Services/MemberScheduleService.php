<?php

namespace App\Modules\Shifts\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\Shifts\Entities\MemberSchedule;
use App\Modules\Shifts\Repositories\MemberScheduleRepository;
use App\Modules\Shifts\Repositories\ShiftRepository;

class MemberScheduleService extends AbstractCoreService
{
    protected $repository;

    public function __construct(MemberScheduleRepository $repository)
    {
        $this->repository = $repository;
    }


}
