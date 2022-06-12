<?php

namespace App\Modules\Distribution\Facades;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Modules\Distribution\Entities\TaskDistributionLog;
use Facades\App\Modules\Distribution\Facades\Integrations\JIRA;
use App\Modules\Distribution\Traits\MemberCapacityCalculationTrait;

class CreateDistributedTasksOnJiraFacade
{
    use MemberCapacityCalculationTrait;

    public function createTaskForATeamMember($task, $teamMember, $team, $schedule, string $taskType): bool
    {
        try {
            $currentMemberCapacity = $this->getCurrentCapacityForATeamMemberToday(
                $teamMember['id'],
                $schedule->id,
                $taskType
            );

            $jiraTask = JIRA::createIssue(
                $team->jira_project_key,
                now()->toDateString().' '.$schedule->name.'⏰ -> '. $task['name'],
                $task['description'],
                $teamMember['jira_integration_id']
            );

            $loggedTask = TaskDistributionLog::create([
                'team_id'                => $team->id,
                'team_member_id'         => $teamMember['id'],
                'schedule_id'            => $schedule->id,
                'task_id'                => $task['id'],
                'task_type'              => $taskType,
                'before_member_capacity' => $currentMemberCapacity,
                'after_member_capacity'  => $currentMemberCapacity - $task['points'],
            ]);
        } catch (Exception $e) {
            // Exception should be handled there
            Log::warning($e->getMessage());

            return false;
        }

        return !(!$jiraTask or !$loggedTask);
    }
}
