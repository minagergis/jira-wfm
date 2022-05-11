<?php

namespace App\Modules\Distribution\Facades;

use App\Modules\Distribution\Entities\TaskDistributionLog;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use App\Modules\Distribution\Traits\MemberCapacityCalculationTrait;

class NormalTasksDistributionFacade
{
    use MemberCapacityCalculationTrait;

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
            ->shift($shiftId)
            ->taskType(TaskDistributionRatiosEnum::PER_SHIFT)
            ->where('team_member_id', $teamMember['id'])
            ->get();

        $currentWeightForTeamMember = $this->getCurrentCapacityForATeamMemberToday(
            $teamMember['id'],
            $shiftId,
            TaskDistributionRatiosEnum::PER_SHIFT
        );
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
