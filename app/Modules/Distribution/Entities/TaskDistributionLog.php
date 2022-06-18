<?php

namespace App\Modules\Distribution\Entities;

use App\Modules\Teams\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Shifts\Entities\MemberSchedule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskDistributionLog extends Model
{
    use HasFactory;

    protected $table = 'tasks_distribution_log';

    protected $fillable = [
        'is_created_on_jira',
        'team_id',
        'team_member_id',
        'task_id',
        'schedule_id',
        'task_type',
        'jira_issue_key',
        'before_member_capacity',
        'after_member_capacity',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(MemberSchedule::class);
    }

    /**
     * Scope a query to only include logs for today.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDay('created_at', now()->day);
    }

    /**
     * Scope a query to only include logs for task types.
     *
     * @param Builder $query
     * @param string  $type
     *
     * @return Builder
     */
    public function scopeTaskType(Builder $query, string $type): Builder
    {
        return $query->where('task_type', $type);
    }

    /**
     * Scope a query to only include logs for a certain shift and team.
     *
     * @param Builder $query
     * @param         $scheduleId
     * @param         $teamId
     *
     * @return Builder
     */
    public function scopeScheduleAndTeam(Builder $query, $scheduleId, $teamId): Builder
    {
        return $query->where([
            'schedule_id' => $scheduleId,
            'team_id'     => $teamId,
        ]);
    }

    /**
     * Scope a query to only include logs for a certain shift.
     *
     * @param Builder $query
     * @param         $scheduleId
     *
     * @return Builder
     */
    public function scopeSchedule(Builder $query, $scheduleId): Builder
    {
        return $query->where('schedule_id', $scheduleId);
    }

    /**
     * Scope a query to only include logs for latest log.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeLatest(Builder $query): Builder
    {
        return  $query->orderBy('id', 'desc');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Scope a query to only include logs for latest log.
     *
     * @param Builder $query
     * @param         $teamMemberId
     *
     * @return Builder
     */
    public function scopeTeamMember(Builder $query, $teamMemberId): Builder
    {
        return  $query->where('team_member_id', $teamMemberId);
    }

    public function scopeWithInDays(Builder $query, int $daysNumber): Builder
    {
        $to   = now();
        $from = now()->subDays($daysNumber);

        return $query->whereBetween('created_at', [$from , $to]);
    }
}
