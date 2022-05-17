<?php

namespace App\Modules\TeamMembers\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
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

    public function __construct(TeamMemberService $teamMemberService, TeamService $teamService)
    {
        $this->teamMemberService = $teamMemberService;
        $this->teamService       = $teamService;
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

        return redirect()->route('get.team-member.list')->with(['status' => 'Team member has been created successfully']);
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

        return redirect()->route('get.team-member.list')->with(['status' => 'Team member has been edited successfully']);
    }

    public function getAssignShift($id)
    {
        $teamMember      = $this->teamMemberService->read($id);

        return view('teammembers::assign_shift', compact('teamMember'));
    }

    public function postAssignShift($id, AssignShiftToMemberRequest $request): RedirectResponse
    {
        $this->teamMemberService->assignShift($id, $request->all());

        return redirect()->route('get.team-member.list')->with(['status' => 'Shift has been assigned successfully']);
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
        $teamMember = $this->teamMemberService->read($id);
        $teams      = $this->teamService->index();

        [$perShiftTasksDone, $zendeskTasksDone] = $this->getLastDaysInsights(7, $id);

        $allLogs = TaskDistributionLog::withInDays(7)->teamMember($id)
            ->latest()
            ->get();

        //dd($teamMember->teams[0]->teamMembers);


        if (!$teamMember) {
            return $this->showErrorMessage('get.team-member.list');
        }

        return view('teammembers::statistics', compact('teamMember', 'teams', 'perShiftTasksDone', 'zendeskTasksDone', 'allLogs'));
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
}
