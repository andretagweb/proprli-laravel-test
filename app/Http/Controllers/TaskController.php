<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource with pagination and filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::with(['comments', 'building', 'assignedUser'])
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->when($request->building_id, fn($query) => $query->where('building_id', $request->building_id))
            ->when($request->assigned_user_id, fn($query) => $query->where('assigned_user_id', $request->assigned_user_id))
            ->when($request->start_date && $request->end_date, fn($query) => $query->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->paginate(10);

        return response()->json(TaskResource::collection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return response()->json(new TaskResource($task), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::with(['comments', 'building', 'assignedUser'])->findOrFail($id);

        return response()->json(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());

        return response()->json(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }
}
