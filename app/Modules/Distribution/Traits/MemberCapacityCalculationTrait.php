<?php

namespace  App\Modules\Distribution\Traits;

use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\Distribution\Entities\TaskDistributionLog;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;

trait MemberCapacityCalculationTrait
{
    public function getCurrentCapacityForATeamMemberToday(int $teamMemberId, int $scheduleId, string $taskType)
    {
        $teamMember = TeamMember::find($teamMemberId);

        $logsForMemberInShift = TaskDistributionLog::today()
            ->schedule($scheduleId)
            ->taskType($taskType)
            ->where('team_member_id', $teamMember->id)
            ->latest()
            ->first();

        // Getting the last weight for this member
        return $logsForMemberInShift->after_member_capacity
            ?? $teamMember->weight * TaskDistributionRatiosEnum::TYPES_RATIOS[$taskType];
    }
}
