<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Task;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }

    public function getCommentsByTask(string $taskId, int $perPage = 10)
    {
        return $this->model->where('task_id', $taskId)->paginate($perPage);
    }

    public function createComment(string $taskId, array $data): Comment
    {
        $task = Task::findOrFail($taskId);
        return $task->comments()->create($data);
    }

    public function findCommentById(string $taskId, string $commentId)
    {
        return $this->model->where('task_id', $taskId)->findOrFail($commentId);
    }

    public function updateComment(Comment $comment, array $data): Comment
    {
        return $this->update($comment, $data);
    }

    public function deleteComment(Comment $comment): bool
    {
        return $this->delete($comment);
    }
}
