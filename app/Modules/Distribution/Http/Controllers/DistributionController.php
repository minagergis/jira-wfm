<?php

namespace App\Modules\Distribution\Http\Controllers;

use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Services\ShiftService;
use App\Modules\Distribution\Jobs\DailyTaskDistribution;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use Facades\App\Modules\Distribution\Facades\NormalTasksDistributionFacade;
use Facades\App\Modules\Distribution\Facades\CreateDistributedTasksOnJiraFacade;

class DistributionController extends AbstractCoreController
{
    private $shiftService;

    private $teamService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ShiftService $shiftService, TeamService $teamService)
    {
        $this->shiftService = $shiftService;
        $this->teamService  = $teamService;
    }

    public function mina()
    {
        DailyTaskDistribution::dispatch();
        die();
        $newArray = [];
        $teams    = $this->teamService->index();
        foreach ($teams as $team) {
            $teamShifts  = $team->shifts()->get();
            $teamTasks   = $team->tasks()->get();
            $teamMembers = $team->teamMembers()->get();

            //dd($teamTasks->first()->toArray());
            foreach ($teamTasks as $task) {
                foreach ($teamShifts as $shift) {
                    foreach ($teamMembers as $member) {
                        if (in_array($shift->id, $member->shifts()->pluck('shift_id')->toArray())) {
                            if ($task->frequency === 'per_shift') {
                                $newArray[$team->name][$shift->name][$member->name][]=$task->name;
                            }
                        }
                    }
                }
            }
        }

        dd(json_encode($newArray));

        return $newArray;
    }

    public function testing()
    {
        $teams = $this->teamService->index();

        foreach ($teams as $team) {
            if (! $team->shifts or ! $team->tasks or ! $team->teamMembers) {
                continue;
            }

            if ($team->perShiftTasks) {
                foreach ($team->shifts as $shift) {
                    $shiftTasks      = $team->perShiftTasks->toArray();
                    $shiftMembers    = $shift->teamMembersForCertainTeam($team->id, $shift->id)->get()->toArray();
                    foreach ($shiftMembers as $member) {
                        $tasksForMember =  NormalTasksDistributionFacade::distributeTasksForTeamMember($member, $shiftTasks, $shift->id);

                        foreach ($tasksForMember as $task) {
                            CreateDistributedTasksOnJiraFacade::createTaskForATeamMember($task, $member, $team, $shift);
                        }
                    }
                    //dd($shiftTasks);
                }
            }

            // If have daily tasks

            //
            //dd($team);

        }
    }
}
