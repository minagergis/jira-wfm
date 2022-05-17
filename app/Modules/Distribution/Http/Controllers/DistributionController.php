<?php

namespace App\Modules\Distribution\Http\Controllers;

use App\Modules\Distribution\Jobs\DailyTaskDistribution;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use Facades\App\Modules\Distribution\Facades\NormalTasksDistributionFacade;
use Facades\App\Modules\Distribution\Facades\CreateDistributedTasksOnJiraFacade;

class DistributionController extends AbstractCoreController
{
    private $teamService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TeamService $teamService)
    {
        $this->teamService  = $teamService;
    }

    public function distribute(): \Illuminate\Http\RedirectResponse
    {
        DailyTaskDistribution::dispatch();

        return redirect()->route('home')->with(['status' => 'Distribution has been created successfully']);
    }

    public function testing()
    {
        $teams = $this->teamService->index();

        foreach ($teams as $team) {
            if (! $team->shifts or ! $team->tasks or ! $team->teamMembers) {
                continue;
            }

            if ($team->perShiftTasks) {
                $this->distributePerShiftTasksForATeam($team);
            }

            if ($team->dailyTasks) {
                $this->distributePerShiftTasksForATeam($team);
            }

        }
    }

    /**
     * @param $team
     *
     * @return void
     */
    private function distributePerShiftTasksForATeam($team): void
    {
        foreach ($team->shifts as $shift) {
            $shiftTasks   = $team->perShiftTasks->toArray();
            $shiftMembers = $shift->teamMembersForCertainTeam($team->id, $shift->id)->get()->toArray();
            foreach ($shiftMembers as $member) {
                $tasksForMember = NormalTasksDistributionFacade::distributePerShiftTasksForTeamMember($member, $shiftTasks, $shift->id);

                foreach ($tasksForMember as $task) {
                    CreateDistributedTasksOnJiraFacade::createTaskForATeamMember(
                        $task,
                        $member,
                        $team,
                        $shift,
                        TaskDistributionRatiosEnum::PER_SHIFT
                    );
                }
            }
        }
    }
}
