<?php

namespace App\Modules\Shifts\Http\Controllers;

use App\Modules\Shifts\Jobs\BulkShiftSchedulingJob;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Services\ShiftService;
use App\Modules\TeamMembers\Services\TeamMemberService;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\Shifts\Http\Requests\Bulk\BulkScheduleRequest;

class BulkShiftController extends AbstractCoreController
{
    private ShiftService $shiftService;

    private TeamMemberService $teamMemberService;

    private TeamService $teamService;

    public function __construct(ShiftService $shiftService, TeamMemberService $teamMemberService, TeamService $teamService)
    {
        $this->shiftService      = $shiftService;
        $this->teamMemberService = $teamMemberService;
        $this->teamService       = $teamService;
    }

    public function index()
    {
        $teams = $this->teamService->index();

        return view('shifts::bulk.index', compact('teams'));
    }

    public function getSchedule($teamId)
    {
        if (auth()->user()->hasRole('team-leader') && auth()->user()->managed_team_id != $teamId) {
            throw new UnauthorizedException(200);
        }

        $shifts      = $this->shiftService->getShiftsByTeam($teamId);
        $teamMembers = $this->teamMemberService->getTeamMembersByTeamId($teamId);

        return view('shifts::bulk.schedule', compact('shifts', 'teamMembers', 'teamId'));
    }

    public function postSchedule(BulkScheduleRequest $request, $teamId)
    {

        BulkShiftSchedulingJob::dispatch(
            $request->get('shift'),
            $request->get('team_members'),
            $request->get('recurring_from'),
            $request->get('recurring_to')

        );


        return redirect()->route('get.shifts.bulk.schedule.teams')->with([
            'alert-type' => 'success',
            'message'    => 'The shifts will be scheduled soon!',
        ]);
    }
}
