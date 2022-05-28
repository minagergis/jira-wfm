<?php

namespace App\Modules\ContactTypes\Services;

use App\Modules\ContactTypes\Repositories\ContactTypeRepository;
use App\Modules\Core\Services\AbstractCoreService;

class ContactTypeService extends AbstractCoreService
{
    protected $repository;

    public function __construct(ContactTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
