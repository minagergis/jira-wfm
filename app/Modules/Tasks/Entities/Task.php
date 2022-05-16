<?php

namespace App\Modules\Tasks\Entities;

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
