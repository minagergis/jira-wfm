<?php

namespace App\Modules\TeamMembers\Http\Controllers;

use App\Modules\TeamMembers\Http\Requests\UpdateTeamMemberRequest;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\TeamMembers\Http\Requests\CreateTeamMemberRequest;

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
     * @return \Illuminate\Http\RedirectResponse
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

        return view('teammembers::show', compact('teamMember','teams'));
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
