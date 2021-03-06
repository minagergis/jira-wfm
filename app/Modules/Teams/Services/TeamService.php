<?php

namespace App\Modules\Teams\Services;

use App\Modules\Core\Services\AbstractCoreService;
use App\Modules\Teams\Repositories\TeamRepository;

class TeamService extends AbstractCoreService
{
    protected $repository;

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }


    public function getTeamByJiraProjectCode($jiraProjectCode)
    {
        return $this->repository->findWithConditions(['jira_project_key'=>$jiraProjectCode]);
    }
}
