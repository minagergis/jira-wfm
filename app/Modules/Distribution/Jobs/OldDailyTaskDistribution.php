<?php

namespace App\Modules\Distribution\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use Facades\App\Modules\Distribution\Facades\NormalTasksDistributionFacade;
use Facades\App\Modules\Distribution\Facades\CreateDistributedTasksOnJiraFacade;

class OldDailyTaskDistribution implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $teamService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->teamService       = resolve(TeamService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $teams = $this->teamService->index();

        foreach ($teams as $team) {
            if (! $team->shifts or ! $team->perShiftTasks or ! $team->teamMembers) {
                continue;
            }

            $this->distributePerShiftTasksForATeam($team);
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
