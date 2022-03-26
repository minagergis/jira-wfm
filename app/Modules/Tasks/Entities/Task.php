<?php

namespace App\Modules\Tasks\Entities;

use App\Modules\Teams\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'frequency',
        'points',
        'is_automatic',
        'team_id'
    ];


    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
