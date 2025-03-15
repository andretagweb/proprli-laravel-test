<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Filters\TaskFilters;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource with pagination and filtering.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->query('per_page', 10);
        $tasks = $this->taskRepository->getAllTasks(new TaskFilters($request), $perPage);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskRepository->createTask($request->validated());

        return response()->json(new TaskResource($task), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $task = $this->taskRepository->findTaskById($id);

        return response()->json(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = $this->taskRepository->findTaskById($id);
        $updatedTask = $this->taskRepository->updateTask($task, $request->validated());

        return response()->json(new TaskResource($updatedTask));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = $this->taskRepository->findTaskById($id);
        $this->taskRepository->deleteTask($task);

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }
}
