<?php

namespace App\Scopes;

use App\Modules\Tasks\Entities\Task;
use App\Modules\Teams\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Shifts\Entities\MemberSchedule;
use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\Distribution\Entities\TaskDistributionLog;

class AuthUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() && auth()->user()->hasRole('team-leader')) {
            if ($model instanceof Team) {
                $builder->where('teams.id', auth()->user()->managed_team_id);
            }

            if ($model instanceof TeamMember) {
                $builder->whereHas('teams', function (Builder $query) {
                    $query->where('teams.id', auth()->user()->managed_team_id);
                });
            }

            if ($model instanceof Task) {
                $builder->where('tasks.team_id', auth()->user()->managed_team_id);
            }

            if ($model instanceof TaskDistributionLog) {
                $builder->where('tasks_distribution_log.team_id', auth()->user()->managed_team_id);
            }

            if ($model instanceof MemberSchedule) {
                $teamMembersId = TeamMember::all()->pluck('id');
                $builder->whereIn('member_schedules.team_member_id', $teamMembersId);
            }
        }
    }
}
