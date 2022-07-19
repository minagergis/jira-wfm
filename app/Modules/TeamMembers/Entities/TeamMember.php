<?php

namespace App\Modules\TeamMembers\Entities;

use App\Scopes\AuthUserScope;
use App\Modules\Teams\Entities\Team;
use App\Modules\Shifts\Entities\Shift;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Shifts\Entities\MemberSchedule;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamMember extends Model
{
    protected $table = 'team_members';

    protected $fillable = [
        'name',
        'is_active',
        'jira_integration_id',
        'weight',
        'color',
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

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members_team');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(MemberSchedule::class, 'team_member_id');
    }

    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class, 'team_members_shifts');
    }

    public function scopeActive($query)
    {
        return $query->where('team_member.is_active', '1');
    }

    public function scopeInShiftNow($query)
    {
        return $query->where('team_member.is_in_shift_now', '1');
    }

    public function scopeWithInDays($query, int $daysNumber)
    {
        $to   = now();
        $from = now()->subDays($daysNumber);

        return $query->whereBetween('created_at', [$from , $to]);
    }
}
