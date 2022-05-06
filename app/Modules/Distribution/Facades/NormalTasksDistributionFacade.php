<?php

namespace App\Modules\Distribution\Facades;

use App\Modules\Distribution\Entities\TaskDistributionLog;

class NormalTasksDistributionFacade
{
    /**
     * @param array $teamMember     Team member data
     * @param array $availableTasks Available tasks for this team member
     * @param int   $shiftId
     *
     * @return array
     */
    public function distributeTasksForTeamMember(array $teamMember, array $availableTasks, int $shiftId): array
    {
        $distributedTasks = [];

        $logsForThisShift = TaskDistributionLog::today()
            ->shiftAndTeam($shiftId, $teamMember['team_id'])
            ->get();

        // Getting the last weight for this member
        $lastWeightForTeamMember = $logsForThisShift
            ->where('team_member_id', $teamMember['id'])
            ->sortByDesc('id')->first()->after_member_capacity ?? $teamMember['weight'] ;


        // Looping for all given tasks
        foreach ($availableTasks as $task) {
            $loggedTask = $logsForThisShift->where('team_member_id', $teamMember['id'])
                ->where('task_id', $task['id'])
                ->count();

            // If the team member still has capacity for the task and this task is not logged yet
            if ($lastWeightForTeamMember >= $task['points'] and $loggedTask === 0) {
                // It will be assigned for him/her then decrease his capacity with the task weight
                $distributedTasks[] = $task;
                $lastWeightForTeamMember -= $task['points'];
            }
        }

        return $distributedTasks;
    }
}
