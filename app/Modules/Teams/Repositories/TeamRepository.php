<?php

namespace App\Modules\Teams\Repositories;

use App\Modules\Core\Repositories\AbstractCoreRepository;
use App\Modules\Teams\Entities\Team;

class TeamRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(Team $team)
    {
        $this->model = $team;
    }
}
