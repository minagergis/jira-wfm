<?php

namespace App\Http\Controllers;

use App\Modules\Tasks\Entities\Task;
use App\Modules\Tasks\Services\TaskService;
use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Teams\Entities\Team;
use App\Modules\Teams\Services\TeamService;

class DashboardController extends Controller
{
    private $teamMemberService;

    private $taskService;

    private $teamService;

    public function __construct(TeamMemberService $teamMemberService, TaskService $taskService , TeamService $teamService)
    {
        $this->middleware('auth');

        $this->teamMemberService = $teamMemberService;
        $this->taskService       = $taskService;
        $this->teamService       = $teamService;
    }


    public function getDashboard()
    {
        $teamMembersCount = $this->teamMemberService->index()->count();
        $teamMembersLastDaysCount =TeamMember::withInDays(7)->get()->count();
        $tasksCount = $this->taskService->index()->count();
        $tasksLastDaysCount =Task::withInDays(7)->get()->count();
        $teamsCount = $this->teamService->index()->count();
        $teamsLastDaysCount =Team::withInDays(7)->get()->count();

        return view('dashboard',compact('teamMembersCount','teamMembersLastDaysCount','tasksCount','tasksLastDaysCount','teamsCount','teamsLastDaysCount'));
    }
}
