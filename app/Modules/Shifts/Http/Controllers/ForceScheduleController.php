<?php

namespace App\Modules\Shifts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Jobs\SwappingShiftJob;
use App\Modules\Shifts\Entities\MemberSchedule;
use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\Shifts\Services\MemberScheduleService;
use App\Modules\Shifts\Jobs\DeleteShiftTasksFromJiraJob;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\Distribution\Services\TaskDistributionLogService;
use App\Modules\Integration\Jobs\HRMS\EditScheduleIntegrationJob;
use App\Modules\Integration\Jobs\HRMS\DeleteScheduleIntegrationJob;

class ForceScheduleController extends AbstractCoreController
{
    private $memberScheduleService;

    private $teamService;

    private $distributionLogService;

    public function __construct(MemberScheduleService $memberScheduleService, TeamService $teamService, TaskDistributionLogService $distributionLogService)
    {
        $this->memberScheduleService  = $memberScheduleService;
        $this->teamService            = $teamService;
        $this->distributionLogService = $distributionLogService;
    }

    public function listTodayShiftsForTeam($id)
    {
        $team      = $this->teamService->read($id);
        $schedules = collect([]);
        foreach ($team->teamMembers as $teamMember) {
            $memberScheduleToday = MemberSchedule::query()
                ->where('team_member_id', $teamMember->id)
                ->whereBetween(
                    DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                    [
                        now('Africa/Cairo')->startOfDay()->toDateTimeString(),
                        now('Africa/Cairo')->endOfDay()->toDateTimeString(),
                    ]
                )->get();

            $schedules =  $schedules->merge($memberScheduleToday);
        }

        return view('shifts::shift_changer.index', compact('schedules'));
    }

    public function forceDeleteSchedule($id)
    {
        $schedule = $this->memberScheduleService->read($id);

        if ($this->memberScheduleService->delete($id)) {
            $assignedDeletedShiftMember = $schedule->member;
            DeleteScheduleIntegrationJob::dispatch($id);
            DeleteShiftTasksFromJiraJob::dispatch($assignedDeletedShiftMember);

            return response()->json([
                'message'=> 'Deleted',
            ]);
        }

        return response()->json([
            'message'=> 'Something went wrong !',
        ]);
    }

    public function getPeopleSwapping($id)
    {
        $memberSchedule = $this->memberScheduleService->read($id);

        $teamMembers = $memberSchedule->member->teams->first()->teamMembers;

        $memberScheduleToday = MemberSchedule::query()
            ->whereIn('team_member_id', $teamMembers->pluck('id')->toArray())
            ->whereBetween(
                DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                [
                    now('Africa/Cairo')->startOfDay()->toDateTimeString(),
                    now('Africa/Cairo')->endOfDay()->toDateTimeString(),
                ]
            )->get();

        $memberWhoseScheduleToday = $memberScheduleToday->pluck('team_member_id')->toArray();
        $members                  = $this->teamService->read($memberSchedule->member->teams->first()->id)->teamMembers->whereNotIn('id', $memberWhoseScheduleToday)->where('is_active', 1);

        return view('shifts::shift_changer.swap', compact('memberSchedule', 'members'));
    }

    public function postPeopleSwapping(Request $request, $id)
    {
        $schedule = $this->memberScheduleService->read($id);

        $oldMember = $schedule->member;
        $newMember = TeamMember::find($request->get('new_member_id'));


        SwappingShiftJob::dispatch($schedule, $oldMember, $newMember);

        $schedule->team_member_id = $newMember->id;
        $schedule->save();

        $editedSchedule = $this->memberScheduleService->read($id);

        EditScheduleIntegrationJob::dispatch($editedSchedule);

        return redirect()->route('get.schedule.shift-changer', $oldMember->teams->first()->id)
            ->with([
                'alert-type' => 'success',
                'message'    => 'Shift has been swapped successfully',
            ]);
    }
}
