<?php

namespace App\Modules\Shifts\Entities;

use App\Modules\Teams\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\TeamMembers\Entities\TeamMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'name',
        'description',
        'days',
        'time_from',
        'time_to',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_shifts');
    }

    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(TeamMember::class, 'team_members_shifts');
    }

    public function scopeTeamMembersForCertainTeam(Builder $query, $teamId, $shiftId): Builder
    {
        return $query
            ->leftJoin('team_members_shifts', 'team_members_shifts.shift_id', '=', 'shifts.id')
            ->join('team_members', 'team_members.id', '=', 'team_members_shifts.team_member_id')
            ->join('team_members_team', 'team_members_team.team_member_id', '=', 'team_members_shifts.team_member_id')
            ->where('team_members_team.team_id', $teamId)
            ->where('shifts.id', $shiftId)
            ->select(
                'team_members.id as id',
                'team_members.name as name',
                'team_members.is_active',
                'team_members.jira_integration_id',
                'team_members_team.team_id',
                'team_members.weight',
            );
    }

    public function scopeWithInDays($query, int $daysNumber)
    {
        $to   = now();
        $from = now()->subDays($daysNumber);

        return $query->whereBetween('created_at', [$from , $to]);
    }
}
