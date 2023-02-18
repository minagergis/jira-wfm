<?php

namespace App\Modules\Shifts\Entities;

use App\Scopes\AuthUserScope;
use Illuminate\Database\Eloquent\Model;
use App\Modules\TeamMembers\Entities\TeamMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AuthUserScope());
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }

    public function scopeWithInDays($query, int $daysNumber)
    {
        $to   = now()->toDateString();
        $from = now()->subDays($daysNumber)->toDateString();

        return $query->whereBetween('date_from', [$from , $to]);
    }

    public function scopeTeamMember($query, $memberId)
    {
        return $query->where('team_member_id', $memberId)
            ->where('date_from', '<=', now()->toDateString());
    }
}
