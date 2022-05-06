<?php

namespace App\Modules\Distribution\Facades;

use Exception;
use Illuminate\Support\Facades\Log;
use Facades\App\Modules\JiraIntegration\Facades\JIRA;
use App\Modules\Distribution\Entities\TaskDistributionLog;

class CreateDistributedTasksOnJiraFacade
{
    public function createTaskForATeamMember($task, $teamMember, $team, $shift): bool
    {
        try {
            $lastMemberCapacity = TaskDistributionLog::today()
                ->shiftAndTeam($shift->id, $teamMember['team_id'])
                ->where('team_member_id', $teamMember['id'])
                ->latest()
                ->first()
                ->after_member_capacity ?? $teamMember['weight'];


            $jiraTask = JIRA::createIssue(
                $team->jira_project_key,
                $shift->name . ' - ' . $task['name'],
                $task['description'],
                $teamMember['jira_integration_id']
            );

            $loggedTask = TaskDistributionLog::create([
                'team_id'                => $team->id,
                'team_member_id'         => $teamMember['id'],
                'shift_id'               => $shift->id,
                'task_id'                => $task['id'],
                'before_member_capacity' => $lastMemberCapacity,
                'after_member_capacity'  => $lastMemberCapacity - $task['points'],
            ]);
        } catch (Exception $e) {
            // Exception should be handled there
            Log::warning($e->getMessage());

            return false;
        }

        return !(!$jiraTask or !$loggedTask);
    }
}
