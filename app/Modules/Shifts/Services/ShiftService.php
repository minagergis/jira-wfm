<?php

namespace App\Modules\Shifts\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\Shifts\Repositories\ShiftRepository;

class ShiftService extends AbstractCoreService
{
    protected $repository;

    public function __construct(ShiftRepository $repository)
    {
        $this->repository = $repository;
    }
}
