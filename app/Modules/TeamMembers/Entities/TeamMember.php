<?php

namespace App\Modules\TeamMembers\Entities;

use App\Modules\Teams\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamMember extends Model
{
    protected $table = 'team_members';

    protected $fillable = [
        'name',
        'is_active',
        'jira_integration_id',
        'weight',
        'is_in_shift_now',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members_team');
    }

    public function scopeActive($query)
    {
        return $query->where('team_member.is_active', '1');
    }

    public function scopeInShiftNow($query)
    {
        return $query->where('team_member.is_in_shift_now', '1');
    }
}
