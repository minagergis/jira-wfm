<?php

namespace App\Modules\Shifts\Http\Controllers;

use Carbon\Carbon;
use Faker\Factory;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Services\MemberScheduleService;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\Shifts\Http\Requests\MemberSchedules\CreateMemberScheduleRequest;
use App\Modules\Shifts\Http\Requests\MemberSchedules\DeleteMemberScheduleRequest;
use App\Modules\Shifts\Http\Requests\MemberSchedules\UpdateMemberScheduleRequest;

class ScheduleController extends AbstractCoreController
{
    private $memberScheduleService;

    private $teamService;

    public function __construct(MemberScheduleService $memberScheduleService, TeamService $teamService)
    {
        $this->memberScheduleService = $memberScheduleService;
        $this->teamService           = $teamService;
    }

    public function scheduleCalendarForTeam($id)
    {
        $faker = Factory::create();
        $team  = $this->teamService->read($id);

        if (! $team) {
            return $this->showErrorMessage('get.teams.list');
        }

        $teamMembers = $team->teamMembers->map(function ($item, $key) use ($faker) {
            $item['color']     = $item->color ?? $faker->hexColor;
            $item['schedules'] = $item->schedules;

            return $item;
        });



        return view('shifts::schedule_calendar', compact('teamMembers'));
    }

    public function addSchedule(CreateMemberScheduleRequest $request)
    {
        $memberScheduleAdded = $this->memberScheduleService->create($request->validated());

        if ($memberScheduleAdded) {
            return response()->json([
                'message'    => 'success',
                'scheduleId' => $memberScheduleAdded->id,
            ]);
        }

        return false;
    }

    public function editSchedule(UpdateMemberScheduleRequest $request)
    {
        $schedule         =(array) json_decode($request->get('data'));
        $memberScheduleId = $schedule['schedule']->id;
        $changes          = [];
        foreach ((array) $schedule['changes'] as $key => $value) {
            if ($key === 'start') {
                $changes['time_from'] = Carbon::parse($value->_date)->timezone('Africa/Cairo')->toTimeString();
                $changes['date_from'] = Carbon::parse($value->_date)->timezone('Africa/Cairo')->toDateString();
            } elseif ($key === 'end') {
                $changes['time_to'] = Carbon::parse($value->_date)->timezone('Africa/Cairo')->toTimeString();
                $changes['date_to'] = Carbon::parse($value->_date)->timezone('Africa/Cairo')->toDateString();
            } elseif ($key === 'calendarId') {
                $changes['team_member_id'] = $value;
            } elseif ($key === 'title') {
                $changes['name'] = $value;
            } else {
                continue;
            }
        }

        if ($this->memberScheduleService->update($changes, $memberScheduleId)) {
            return response()->json([
                'message'  => 'success',
            ]);
        }

        return false;
    }

    public function deleteSchedule(DeleteMemberScheduleRequest $request)
    {
        if ($this->memberScheduleService->delete($request->validated()['id'])) {
            return response()->json([
                'message'  => 'success',
            ]);
        }

        return false;
    }
}
