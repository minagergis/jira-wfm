<?php

namespace App\Modules\Shifts\Repositories;

use App\Modules\Core\Repositories\AbstractCoreRepository;
use App\Modules\Shifts\Entities\Shift;

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
        $shift = $this->model->create($attributes);
        $shift->teams()->attach($attributes['teams']);

        return $shift;
    }
}
