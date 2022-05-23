<?php

namespace App\Modules\Shifts\Http\Controllers;

use App\Modules\Shifts\Enums\DaysEnum;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Shifts\Services\ShiftService;
use App\Modules\Shifts\Http\Requests\UpdateShiftRequest;
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

    public function store(UpdateShiftRequest $request)
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

    public function edit(int $id)
    {
        $teams  = $this->teamService->index();
        $days   = DaysEnum::DAYSValues;
        $shift  = $this->shiftService->read($id);

        if (! $shift) {
            return $this->showErrorMessage('get.shifts.list');
        }

        return view('shifts::edit', compact('teams', 'days', 'shift'));
    }

    public function update(UpdateShiftRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->shiftService->update($request->all(), $id);

        return redirect()->route('get.shifts.list')->with(['status' => 'Shift has been edited successfully']);
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
