<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($taskId): JsonResponse
    {
        $task = Task::findOrFail($taskId);
        return response()->json($task->comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, $taskId): JsonResponse
    {
        $task = Task::findOrFail($taskId);

        $comment = $task->comments()->create($request->validated());

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($taskId, $commentId): JsonResponse
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, $taskId, $commentId): JsonResponse
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        $comment->update($request->validated());

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId, $commentId): JsonResponse
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 204);
    }
}
