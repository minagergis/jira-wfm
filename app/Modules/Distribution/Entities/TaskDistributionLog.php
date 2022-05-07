<?php

namespace App\Modules\Distribution\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        'shift_id',
        'task_type',
        'before_member_capacity',
        'after_member_capacity',
    ];

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
     * @param         $shiftId
     * @param         $teamId
     *
     * @return Builder
     */
    public function scopeShiftAndTeam(Builder $query, $shiftId, $teamId): Builder
    {
        return $query->where([
            'shift_id' => $shiftId,
            'team_id'  => $teamId,
        ]);
    }

    /**
     * Scope a query to only include logs for a certain shift.
     *
     * @param Builder $query
     * @param         $shiftId
     *
     * @return Builder
     */
    public function scopeShift(Builder $query, $shiftId): Builder
    {
        return $query->where('shift_id', $shiftId);
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
}
