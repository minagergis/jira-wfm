<?php

namespace App\Modules\Teams\Entities;

use App\Scopes\AuthUserScope;
use App\Modules\Tasks\Entities\Task;
use App\Modules\Shifts\Entities\Shift;
use App\Modules\Teams\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use App\Modules\TeamMembers\Entities\TeamMember;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'name',
        'description',
        'jira_project_key',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AuthUserScope());
    }

    /**
     * @return BelongsToMany
     */
    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(TeamMember::class, 'team_members_team');
    }

    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class, 'team_shifts');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function perShiftTasks(): HasMany
    {
        return $this->hasMany(Task::class)->where('tasks.frequency', TaskDistributionRatiosEnum::PER_SHIFT);
    }

    public function scopeWithInDays($query, int $daysNumber)
    {
        $to   = now();
        $from = now()->subDays($daysNumber);

        return $query->whereBetween('created_at', [$from , $to]);
    }
}
