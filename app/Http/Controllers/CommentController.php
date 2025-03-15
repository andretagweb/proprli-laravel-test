<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($taskId): AnonymousResourceCollection
    {
        $perPage = request('per_page', 10);
        $task = Task::findOrFail($taskId);

        return CommentResource::collection($task->comments()->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, $taskId): CommentResource
    {
        $task = Task::findOrFail($taskId);

        $comment = $task->comments()->create($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show($taskId, $commentId): CommentResource
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, $taskId, $commentId): CommentResource
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        $comment->update($request->validated());

        return new CommentResource($comment);
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
