<?php

namespace App\Modules\Teams\Entities;

use App\Modules\Shifts\Entities\Shift;
use Illuminate\Database\Eloquent\Model;
use App\Modules\TeamMembers\Entities\TeamMember;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'name',
        'description',
    ];

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
}
