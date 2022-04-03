<?php

namespace App\Modules\Shifts\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Shifts\Enums\DaysEnum;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Shifts\Services\ShiftService;
use App\Modules\Shifts\Http\Requests\CreateShiftRequest;
use App\Modules\Core\Http\Controllers\AbstractCoreController;

class ShiftsController extends AbstractCoreController
{
    private $shiftService;

    public function __construct(ShiftService $shiftService, TeamService $teamService)
    {
        $this->shiftService = $shiftService;
        $this->teamService  = $teamService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $shifts = $this->shiftService->index();

        return view('shifts::index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $teams = $this->teamService->index();
        $days  = DaysEnum::DAYSValues;

        return view('shifts::create', compact('teams', 'days'));
    }

    public function store(CreateShiftRequest $request)
    {

        $this->shiftService->create($request->all());

        return redirect()->route('get.shifts.list')->with(['status' => 'Shift has been created successfully']);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('shifts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('shifts::edit');
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
