<?php

namespace App\Modules\Teams\Http\Controllers;

use App\Modules\Teams\Services\TeamService;
use App\Modules\Teams\Http\Requests\CreateTeamRequest;
use App\Modules\Teams\Http\Requests\UpdateTeamRequest;
use App\Modules\Core\Http\Controllers\AbstractCoreController;

class TeamsController extends AbstractCoreController
{
    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index()
    {
        $teams = $this->teamService->index();

        return view('teams::index', compact('teams'));
    }

    public function create()
    {
        return view('teams::create');
    }

    public function store(CreateTeamRequest $request)
    {
        $this->teamService->create($request->all());

        return redirect()->route('get.teams.list')->with(['status' => 'Team has been created successfully']);
    }

    public function show(int $id)
    {
        $team = $this->teamService->read($id);
        if (! $team) {
            return $this->showErrorMessage('get.teams.list');
        }

        return view('teams::show', compact('team'));
    }

    public function edit(int $id)
    {
        $team = $this->teamService->read($id);

        if (! $team) {
            return $this->showErrorMessage('get.teams.list');
        }

        return view('teams::edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request, $id)
    {
        $this->teamService->update($request->all(), $id);

        return redirect()->route('get.teams.list')->with(['status' => 'Team has been edited successfully']);
    }

    public function destroy($id)
    {
        $this->teamService->delete($id);

        return redirect()->route('get.teams.list')->with(['status' => 'Team has been deleted successfully']);
    }
}
