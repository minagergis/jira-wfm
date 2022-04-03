<?php

namespace App\Modules\Teams\Entities;

use App\Modules\Tasks\Entities\Task;
use App\Modules\Shifts\Entities\Shift;
use Illuminate\Database\Eloquent\Model;
use App\Modules\TeamMembers\Entities\TeamMember;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function teamMembers()
    {
        return $this->belongsToMany(TeamMember::class, 'team_members_team');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'team_shifts');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
