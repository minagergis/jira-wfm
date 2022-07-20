<?php

namespace App\Modules\ContactTypes\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Modules\Teams\Services\TeamService;
use App\Modules\ContactTypes\Services\ContactTypeService;
use App\Modules\Core\Http\Controllers\AbstractCoreController;
use App\Modules\ContactTypes\Http\Requests\CreateContactTypeRequest;
use App\Modules\ContactTypes\Http\Requests\UpdateContactTypeRequest;

class ContactTypesController extends AbstractCoreController
{
    private $service;

    private $teamService;

    public function __construct(ContactTypeService $service, TeamService $teamService)
    {
        $this->service     = $service;
        $this->teamService = $teamService;
    }

    public function index()
    {
        $contactTypes = $this->service->index();

        return view('contacttypes::index', compact('contactTypes'));
    }

    public function create()
    {
        $teams = $this->teamService->index();

        return view('contacttypes::create', compact('teams'));
    }

    public function store(CreateContactTypeRequest $request): RedirectResponse
    {
        $this->service->create($request->all());

        return redirect()->route('get.contact-type.list')->with([
            'alert-type' => 'success',
            'message'    => 'Contact type has been created successfully',
        ]);
    }

    public function edit($id)
    {
        $teams       = $this->teamService->index();
        $contactType = $this->service->read($id);
        if (!$contactType) {
            return $this->showErrorMessage('get.contact-type.list');
        }

        return view('contacttypes::edit', compact('contactType', 'teams'));
    }

    public function update(UpdateContactTypeRequest $request, $id): RedirectResponse
    {
        $this->service->update($request->all(), $id);

        return redirect()->route('get.contact-type.list')->with([
            'alert-type' => 'success',
            'message'    => 'Contact type has been edited successfully',
        ]);
    }
}
