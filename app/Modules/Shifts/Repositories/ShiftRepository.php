<?php

namespace App\Modules\Shifts\Repositories;

use App\Modules\Shifts\Entities\Shift;
use App\Modules\Core\Repositories\AbstractCoreRepository;
use Illuminate\Database\Eloquent\Builder;

class ShiftRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(Shift $shift)
    {
        $this->model = $shift;
    }

    public function create($attributes)
    {
        $attributes['days'] = json_encode($attributes['days']);
        $shift              = $this->model->create($attributes);
        $shift->teams()->attach($attributes['teams']);

        return $shift;
    }

    public function update($id, array $attributes): bool
    {
        $attributes['days'] = json_encode($attributes['days']);

        $shift = $this->model->find($id)->update($attributes);

        $this->model->find($id)->teams()->sync($attributes['teams']);

        return $shift;
    }

    public function getShiftsByTeamId($teamId)
    {
        return $this->model->whereHas('teams', function (Builder $query) use ($teamId) {
            $query->where('teams.id', $teamId);
        })->get();
    }
}
