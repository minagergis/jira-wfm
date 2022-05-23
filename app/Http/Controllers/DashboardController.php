<?php

namespace App\Http\Controllers;

use App\Modules\Distribution\Entities\TaskDistributionLog;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use App\Modules\Shifts\Entities\Shift;
use App\Modules\Shifts\Services\ShiftService;
use App\Modules\Tasks\Entities\Task;
use App\Modules\Tasks\Services\TaskService;
use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Teams\Entities\Team;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $teamMemberService;

    private $taskService;

    private $teamService;

    private $shiftService;

    public function __construct(TeamMemberService $teamMemberService, TaskService $taskService , TeamService $teamService,ShiftService $shiftService)
    {
        $this->middleware('auth');

        $this->teamMemberService = $teamMemberService;
        $this->taskService       = $taskService;
        $this->teamService       = $teamService;
        $this->shiftService       = $shiftService;
    }


    public function getDashboard()
    {
        $teamMembersCount = $this->teamMemberService->index()->count();
        $teamMembersLastDaysCount =TeamMember::withInDays(7)->get()->count();
        $tasksCount = $this->taskService->index()->count();
        $tasksLastDaysCount =Task::withInDays(7)->get()->count();
        $teamsCount = $this->teamService->index()->count();
        $teamsLastDaysCount =Team::withInDays(7)->get()->count();
        $shiftsCount = $this->shiftService->index()->count();
        $shiftsLastDaysCount = Shift::withInDays(7)->get()->count();

        return view('dashboard',compact(
            'teamMembersCount',
            'teamMembersLastDaysCount',
            'tasksCount',
            'tasksLastDaysCount',
            'teamsCount',
            'teamsLastDaysCount',
            'shiftsCount',
            'shiftsLastDaysCount',
        ));
    }
}
