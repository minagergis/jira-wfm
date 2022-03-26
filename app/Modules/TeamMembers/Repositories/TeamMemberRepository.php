<?php

namespace App\Modules\TeamMembers\Repositories;

use App\Modules\Core\Repositories\AbstractCoreRepository;
use App\Modules\TeamMembers\Entities\TeamMember;

class TeamMemberRepository extends AbstractCoreRepository {

    protected $model;

    public function __construct(TeamMember $teamMember)
    {
        $this->model = $teamMember;
    }
}
