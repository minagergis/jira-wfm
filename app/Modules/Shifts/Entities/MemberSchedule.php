<?php

namespace App\Modules\Shifts\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Modules\TeamMembers\Entities\TeamMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MemberSchedule extends Model
{
    use HasFactory;

    protected $table = 'member_schedules';

    protected $fillable = [
        'name',
        'description',
        'time_from',
        'time_to',
        'date_from',
        'date_to',
        'team_member_id',
    ];

    public function member(): BelongsToMany
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }
}
