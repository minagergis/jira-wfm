<?php

namespace App\Modules\ContactTypes\Repositories;

use App\Modules\ContactTypes\Entities\ContactType;
use App\Modules\Core\Repositories\AbstractCoreRepository;

class ContactTypeRepository extends AbstractCoreRepository
{
    protected $model;

    public function __construct(ContactType $contactType)
    {
        $this->model = $contactType;
    }
}
