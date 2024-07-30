<?php

namespace App\Modules\TeamMembers\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\TeamMembers\Repositories\TeamMemberRepository;

class TeamMemberService extends AbstractCoreService
{
    protected $repository;

    public function __construct(TeamMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function assignShift($id, $attributes)
    {
        return $this->repository->assignShifts($id, $attributes);
    }

    public function getTeamMembersByTeamId($teamId)
    {
        return $this->repository->getTeamMemberByTeamId($teamId);
    }
    public function getActiveTeamMemberByTeamId($teamId)
    {
        return $this->repository->getActiveTeamMemberByTeamId($teamId);
    }

    public function getTeamMemberWithScheduleInDay($day)
    {
        return $this->repository->getTeamMemberWithScheduleInDay($day);
    }
}
