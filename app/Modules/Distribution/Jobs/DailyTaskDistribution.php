<?php

namespace App\Modules\Distribution\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Modules\Tasks\Services\TaskService;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Shifts\Services\ShiftService;
use Facades\App\Modules\JiraIntegration\Facades\JIRA;
use App\Modules\TeamMembers\Services\TeamMemberService;

class DailyTaskDistribution implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $shiftService;

    private $teamService;

    private $teamMemberService;

    private $taskService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->shiftService      = resolve(ShiftService::class);
        $this->teamService       = resolve(TeamService::class);
        $this->teamMemberService = resolve(TeamMemberService::class);
        $this->taskService       = resolve(TaskService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $perShiftTeamTasks = $this->getPerShiftTasks();

        foreach ($perShiftTeamTasks as $team => $shifts) {
            $team = $this->teamService->read($team);
            foreach ($shifts as $shiftId => $teamMembers) {
                $shift = $this->shiftService->read($shiftId);
                foreach ($teamMembers as $teamMemberId => $tasks) {
                    $teamMember = $this->teamMemberService->read($teamMemberId);
                    foreach ($tasks as $taskId) {
                        $task = $this->taskService->read($taskId);
                        if ($team->jira_project_key) {
                            JIRA::createIssue($team->jira_project_key, $task->name, $task->description, $teamMember->jira_integration_id);
                        }
                    }
                }
            }
        }
    }

    private function getPerShiftTasks(): array
    {
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
                                $newArray[$team->id][$shift->id][$member->id][]=$task->id;
                            }
                        }
                    }
                }
            }
        }

        return $newArray;
    }
}
