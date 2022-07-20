<?php

namespace App\Modules\Tasks\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Modules\Tasks\Services\TaskService;
use App\Modules\Teams\Services\TeamService;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Tasks\Http\Requests\CreateTaskRequest;
use App\Modules\Tasks\Http\Requests\UpdateTaskRequest;
use App\Modules\Core\Http\Controllers\AbstractCoreController;

class TasksController extends AbstractCoreController
{
    private $taskService;

    private $teamService;

    public function __construct(TaskService $taskService, TeamService $teamService)
    {
        $this->taskService = $taskService;
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $tasks = $this->taskService->index();

        return view('tasks::index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $teams = $this->teamService->index();

        return view('tasks::create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateTaskRequest $request
     * @return RedirectResponse
     */
    public function store(CreateTaskRequest $request)
    {
        $this->taskService->create($request->all());

        return redirect()->route('get.tasks.list')->with([
            'alert-type' => 'success',
            'message'    => 'Task has been created successfully',
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        $task       = $this->taskService->read($id);
        $teams      = $this->teamService->index();

        if (!$task) {
            return $this->showErrorMessage('get.task.list');
        }

        return view('tasks::show', compact('task', 'teams'));
    }

    public function edit($id)
    {
        $teams      = $this->teamService->index();
        $task       = $this->taskService->read($id);
        if (!$task) {
            return $this->showErrorMessage('get.tasks.list');
        }

        return view('tasks::edit', compact('task', 'teams'));
    }

    public function update(UpdateTaskRequest $request, $id): RedirectResponse
    {
        $this->taskService->update($request->all(), $id);

        return redirect()->route('get.tasks.list')->with([
            'alert-type' => 'success',
            'message'    => 'Task has been edited successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
