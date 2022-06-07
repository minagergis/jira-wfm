<?php

namespace App\Modules\Shifts\Repositories;

use App\Modules\Shifts\Entities\MemberSchedule;
use App\Modules\Shifts\Entities\Shift;
use App\Modules\Core\Repositories\AbstractCoreRepository;
use Illuminate\Database\Eloquent\Builder;

class MemberScheduleRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(MemberSchedule $memberSchedule)
    {
        $this->model = $memberSchedule;
    }

}
