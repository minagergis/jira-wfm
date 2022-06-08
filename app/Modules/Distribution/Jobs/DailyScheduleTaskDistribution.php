<?php

namespace App\Modules\Distribution\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use Facades\App\Modules\Distribution\Facades\NormalTasksDistributionFacade;
use Facades\App\Modules\Distribution\Facades\CreateDistributedTasksOnJiraFacade;

class DailyScheduleTaskDistribution implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $teamMemberService;

    private $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->teamMemberService = resolve(TeamMemberService::class);
        $this->date              = now('Africa/Cairo')->toDateString();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $members = $this->teamMemberService->getTeamMemberWithScheduleInDay($this->date);

        foreach ($members as $member) {
            $memberTeam = $member->teams[0] ?? false;

            if (! $memberTeam or ! $memberTeam->perShiftTasks) {
                continue;
            }

            $this->distributePerShiftTasksForATeamMember($member);
        }
    }

    private function distributePerShiftTasksForATeamMember($teamMember)
    {
        $teamMemberSchedules = $teamMember->schedules()->where('member_schedules.date_from', 'LIKE', '%'.$this->date.'%')->get();

        foreach ($teamMemberSchedules as $schedule) {
            $scheduleToDoTasks  = $teamMember->teams[0]->perShiftTasks->toArray();

            $toDoTasksForMember = NormalTasksDistributionFacade::distributePerShiftTasksForTeamMember($teamMember->toArray(), $scheduleToDoTasks, $schedule->id);

            foreach ($toDoTasksForMember as $task) {
                CreateDistributedTasksOnJiraFacade::createTaskForATeamMember(
                    $task,
                    $teamMember,
                    $teamMember->teams[0],
                    $schedule,
                    TaskDistributionRatiosEnum::PER_SHIFT
                );
            }
        }
    }
}
