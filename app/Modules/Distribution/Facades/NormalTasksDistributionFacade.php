<?php

namespace App\Modules\Distribution\Facades;

use App\Modules\Distribution\Entities\TaskDistributionLog;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;

class NormalTasksDistributionFacade
{
    /**
     * @param array $teamMember     Team member data
     * @param array $availableTasks Available tasks for this team member
     * @param int   $shiftId
     *
     * @return array
     */
    public function distributePerShiftTasksForTeamMember(array $teamMember, array $availableTasks, int $shiftId): array
    {
        $distributedTasks = [];

        $logsForThisShift = TaskDistributionLog::today()
            ->shiftAndTeam($shiftId, $teamMember['team_id'])
            ->taskType(TaskDistributionRatiosEnum::PER_SHIFT)
            ->where('team_member_id', $teamMember['id'])
            ->get();

        // Getting the last weight for this member
        $currentWeightForTeamMember = $logsForThisShift->sortByDesc('id')->first()->after_member_capacity
            ?? $teamMember['weight'] * TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::PER_SHIFT];

        // Looping for all given tasks
        foreach ($availableTasks as $task) {
            $loggedTask = $logsForThisShift->where('task_id', $task['id'])->count();

            // If the team member still has capacity for the task and this task is not logged yet
            if ($currentWeightForTeamMember >= $task['points'] and $loggedTask === 0) {
                // It will be assigned for him/her then decrease his capacity with the task weight
                $distributedTasks[] = $task;
                $currentWeightForTeamMember -= $task['points'];
            }
        }

        return $distributedTasks;
    }
}
