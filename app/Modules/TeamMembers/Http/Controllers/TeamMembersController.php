<?php

namespace App\Modules\TeamMembers\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Shifts\Services\MemberScheduleService;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Distribution\Entities\TaskDistributionLog;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use App\Modules\TeamMembers\Http\Requests\CreateTeamMemberRequest;
use App\Modules\TeamMembers\Http\Requests\UpdateTeamMemberRequest;
use App\Modules\TeamMembers\Http\Requests\AssignShiftToMemberRequest;

class TeamMembersController extends AbstractCoreController
{
    private $teamMemberService;

    private $teamService;

    private $memberScheduleService;

    public function __construct(TeamMemberService $teamMemberService, TeamService $teamService, MemberScheduleService $memberScheduleService)
    {
        $this->teamMemberService     = $teamMemberService;
        $this->teamService           = $teamService;
        $this->memberScheduleService = $memberScheduleService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $teamMembers = $this->teamMemberService->index();

        return view('teammembers::index', compact('teamMembers'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function indexByTeam($teamId)
    {
        $teamMembers = $this->teamMemberService->getTeamMembersByTeamId($teamId);

        return view('teammembers::index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $teams = $this->teamService->index();

        return view('teammembers::create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateTeamMemberRequest $request
     * @return RedirectResponse
     */
    public function store(CreateTeamMemberRequest $request)
    {
        $this->teamMemberService->create($request->all());

        return redirect()->route('get.team-member.list')->with([
            'alert-type' => 'success',
            'message'    => 'Team member has been created successfully',
        ]);
    }

    public function show($id)
    {
        $teamMember = $this->teamMemberService->read($id);
        $teams      = $this->teamService->index();

        if (!$teamMember) {
            return $this->showErrorMessage('get.team-member.list');
        }

        return view('teammembers::show', compact('teamMember', 'teams'));
    }

    public function edit($id)
    {
        $teams      = $this->teamService->index();
        $teamMember = $this->teamMemberService->read($id);
        if (!$teamMember) {
            return $this->showErrorMessage('get.team-member.list');
        }

        return view('teammembers::edit', compact('teamMember', 'teams'));
    }

    public function update(UpdateTeamMemberRequest $request, $id)
    {
        $this->teamMemberService->update($request->all(), $id);

        return redirect()->route('get.team-member.list')->with([
            'alert-type' => 'success',
            'message'    => 'Team member has been edited successfully',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function statistics($id)
    {
        $numberOfTasks                   = 0;
        $numberOfTasksLast7Days          = 0;
        $totalPointsLastShift            = 0;
        $totalPointsLastShiftForZendesk  = 0;
        $totalPointsLastShiftForPerShift = 0;
        $memberWeightLastShift           = 0;
        $teamMember                      = $this->teamMemberService->read($id);
        $teams                           = $this->teamService->index();
        $lastShift                       = $this->memberScheduleService->withScope('teamMember', $id)->sortByDesc('id')->first();
        $allLogs                         = TaskDistributionLog::withInDays(7)->teamMember($id)->latest()->get();
        if ($lastShift) {
            $memberWeightLastShift = $allLogs->where('schedule_id', $lastShift->id)->sortBy('id')->map(function ($item) {
                if ($item->task_type === TaskDistributionRatiosEnum::PER_SHIFT) {
                    return $item->before_member_capacity / TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::PER_SHIFT];
                }
                if ($item->task_type === TaskDistributionRatiosEnum::ZENDESK) {
                    return $item->before_member_capacity / TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::ZENDESK];
                }
            })->first();

            $numberOfTasks          = $allLogs->where('schedule_id', $lastShift->id)->count();
            $numberOfTasksLast7Days = $allLogs->count();

            $totalPointsLastShift = $allLogs->where('schedule_id', $lastShift->id)->map(function ($item) {
                return $item->before_member_capacity - $item->after_member_capacity;
            })->sum();

            $totalPointsLastShiftForZendesk = $allLogs->where('schedule_id', $lastShift->id)->map(function ($item) {
                if ($item->task_type === TaskDistributionRatiosEnum::ZENDESK) {
                    return $item->before_member_capacity - $item->after_member_capacity;
                }
            })->sum();

            $totalPointsLastShift = $allLogs->where('schedule_id', $lastShift->id)->map(function ($item) {
                return $item->before_member_capacity - $item->after_member_capacity;
            })->sum();

            $totalPointsLastShiftForZendesk = $allLogs->where('schedule_id', $lastShift->id)->map(function ($item) {
                if ($item->task_type === TaskDistributionRatiosEnum::ZENDESK) {
                    return $item->before_member_capacity - $item->after_member_capacity;
                }
            })->sum();

            $totalPointsLastShiftForPerShift = $allLogs->where('schedule_id', $lastShift->id)->map(function ($item) {
                if ($item->task_type === TaskDistributionRatiosEnum::PER_SHIFT) {
                    return $item->before_member_capacity - $item->after_member_capacity;
                }
            })->sum();
        }


        $isInShiftNow = $this->isInShiftNow($lastShift);




        [$perShiftTasksDone, $zendeskTasksDone] = $this->getLastDaysInsights(7, $id);

        if (!$teamMember) {
            return $this->showErrorMessage('get.team-member.list');
        }

        return view('teammembers::statistics', compact(
            'teamMember',
            'teams',
            'perShiftTasksDone',
            'zendeskTasksDone',
            'allLogs',
            'isInShiftNow',
            'totalPointsLastShift',
            'memberWeightLastShift',
            'numberOfTasks',
            'totalPointsLastShiftForPerShift',
            'totalPointsLastShiftForZendesk',
            'numberOfTasksLast7Days'
        ));
    }

    /**
     * @param $lastDaysNumber
     * @param $memberId
     *
     * @return array
     */
    private function getLastDaysInsights($lastDaysNumber, $memberId): array
    {
        $lastWeekInsights = TaskDistributionLog::withInDays($lastDaysNumber)
            ->teamMember($memberId)
            ->select(DB::raw('DATE(created_at) as date'), 'task_type', DB::raw('max(before_member_capacity) as max_capacity'), DB::raw('min(after_member_capacity) as min_capacity'))
            ->groupBy('date', 'task_type')
            ->get();

        $perShiftTasksDone = $lastWeekInsights->map(function ($item) {
            if ($item->task_type === TaskDistributionRatiosEnum::PER_SHIFT) {
                return $item->max_capacity - $item->min_capacity;
            }
        })->sum();

        $zendeskTasksDone = $lastWeekInsights->map(function ($item) {
            if ($item->task_type === TaskDistributionRatiosEnum::ZENDESK) {
                return $item->max_capacity - $item->min_capacity;
            }
        })->sum();

        return [$perShiftTasksDone, $zendeskTasksDone];
    }

    /**
     * @param $lastShift
     *
     * @return void
     */
    private function isInShiftNow($lastShift): bool
    {
        $isInShiftNow = false;
        if ($lastShift) {
            $timeNow        = now()->toDateTimeString();
            $shiftStartDate = Carbon::parse($lastShift->date_from . ' ' . $lastShift->time_from)->toDateTimeString();
            $shiftEndDate   = Carbon::parse($lastShift->date_to . ' ' . $lastShift->time_to)->toDateTimeString();

            if ($timeNow >= $shiftStartDate && $timeNow <= $shiftEndDate) {
                $isInShiftNow = true;
            }
        }

        return $isInShiftNow;
    }
}
