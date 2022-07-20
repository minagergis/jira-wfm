<?php

namespace App\Modules\Tasks\Entities;

use App\Scopes\AuthUserScope;
use App\Modules\Teams\Entities\Team;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'frequency',
        'points',
        'description',
        'is_automatic',
        'team_id',
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

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeWithInDays($query, int $daysNumber)
    {
        $to   = now();
        $from = now()->subDays($daysNumber);

        return $query->whereBetween('created_at', [$from , $to]);
    }
}
