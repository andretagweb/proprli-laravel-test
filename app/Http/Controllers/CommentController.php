<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($taskId): AnonymousResourceCollection
    {
        $perPage = request('per_page', 10);
        $comments = $this->commentRepository->getCommentsByTask($taskId, $perPage);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, $taskId): JsonResponse
    {
        $comment = $this->commentRepository->createComment($taskId, $request->validated());

        return response()->json(new CommentResource($comment), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($taskId, $commentId): JsonResponse
    {
        $comment = $this->commentRepository->findCommentById($taskId, $commentId);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        return response()->json(new CommentResource($comment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, $taskId, $commentId): JsonResponse
    {
        $comment = $this->commentRepository->findCommentById($taskId, $commentId);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $updatedComment = $this->commentRepository->updateComment($comment, $request->validated());

        return response()->json(new CommentResource($updatedComment));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId, $commentId): JsonResponse
    {
        $comment = $this->commentRepository->findCommentById($taskId, $commentId);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $this->commentRepository->deleteComment($comment);

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
