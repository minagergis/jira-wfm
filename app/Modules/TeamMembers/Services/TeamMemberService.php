<?php
namespace App\Modules\TeamMembers\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\TeamMembers\Repositories\TeamMemberRepository;

class TeamMemberService extends AbstractCoreService{

    protected $repository;

    public function __construct(TeamMemberRepository $repository)
    {
        $this->repository = $repository;
    }
}
