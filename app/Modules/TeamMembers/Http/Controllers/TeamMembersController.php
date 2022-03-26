<?php

namespace App\Modules\TeamMembers\Http\Controllers;

use App\Modules\TeamMembers\Http\Requests\CreateTeamMemberRequest;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TeamMembersController extends Controller
{
    private $teamMemberService;
    private $teamService;

    public function __construct(TeamMemberService $teamMemberService,TeamService $teamService)
    {
        $this->teamMemberService = $teamMemberService;
        $this->teamService = $teamService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $teamMembers = $this->teamMemberService->index();

        return view('teammembers::index',compact('teamMembers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $teams = $this->teamService->index();

        return view('teammembers::create',compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateTeamMemberRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTeamMemberRequest $request)
    {
        $this->teamMemberService->create($request->all());

        return redirect()->route('get.team-member.list')->with(['status' => 'Team has been created successfully']);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('teammembers::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('teammembers::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
