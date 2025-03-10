<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::with(['comments', 'building', 'assignedUser'])
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->when($request->building_id, fn($query) => $query->where('building_id', $request->building_id))
            ->when($request->assigned_user_id, fn($query) => $query->where('assigned_user_id', $request->assigned_user_id))
            ->when($request->created_at, fn($query) => $query->whereDate('created_at', $request->created_at))
            ->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,In Progress,Completed,Rejected',
            'assigned_user_id' => 'nullable|exists:users,id',
            'building_id' => 'required|exists:buildings,id',
        ]);

        $task = Task::create($request->all());

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
