<?php

namespace App\Modules\TeamMembers\Repositories;

use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\Core\Repositories\AbstractCoreRepository;

class TeamMemberRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(TeamMember $teamMember)
    {
        $this->model = $teamMember;
    }

    public function create($attributes)
    {
        $teamMember = $this->model->create($attributes);
        $teamMember->teams()->attach($attributes['team']);

        return $teamMember;
    }

    public function update($id, array $attributes): bool
    {
        $teamMember = $this->model->find($id)->update($attributes);

        $this->model->find($id)->teams()->sync($attributes['team']);

        return $teamMember;
    }
}
