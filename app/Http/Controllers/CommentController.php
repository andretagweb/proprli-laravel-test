<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($taskId)
    {
        $task = Task::findOrFail($taskId);
        return response()->json($task->comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string|max:500',
        ]);

        $task = Task::findOrFail($taskId);

        $comment = $task->comments()->create([
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($taskId, $commentId)
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $taskId, $commentId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        $comment->update(['content' => $request->content]);

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId, $commentId)
    {
        $comment = Comment::where('task_id', $taskId)->findOrFail($commentId);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 204);
    }
}
