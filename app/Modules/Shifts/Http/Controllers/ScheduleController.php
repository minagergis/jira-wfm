<?php

namespace App\Modules\Shifts\Http\Controllers;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Services\MemberScheduleService;
use App\Modules\Core\Http\Controllers\AbstractCoreController;

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

    public function addSchedule(Request $request)
    {
        $schedule =(array) json_decode($request->get('data'));

        //dd($schedule['start']->_date, $schedule['end']->_date);
        $memberSchedule = [
            'name'           => $schedule['title'],
            'team_member_id' => $schedule['calendarId'],
            'time_from'      => Carbon::parse($schedule['start']->_date)->timezone('Africa/Cairo')->toTimeString(),
            'time_to'        => Carbon::parse($schedule['end']->_date)->timezone('Africa/Cairo')->toTimeString(),
            'date_from'      => Carbon::parse($schedule['start']->_date)->timezone('Africa/Cairo')->toDateString(),
            'date_to'        => Carbon::parse($schedule['end']->_date)->timezone('Africa/Cairo')->toDateString(),
        ];

        if ($this->memberScheduleService->create($memberSchedule)) {
            return response()->json([
                'message'  => 'success',
            ]);
        }

        return false;
    }

    public function deleteSchedule(Request $request)
    {
        $schedule =(array) json_decode($request->get('data'));

        if ($this->memberScheduleService->delete($schedule['id'])) {
            return response()->json([
                'message'  => 'success',
            ]);
        }

        return false;
    }
}
