<?php

namespace App\Repositories;

use App\Models\Task;
use App\Filters\TaskFilters;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function getAllTasks(TaskFilters $filters, int $perPage = 10)
    {
        $query = $this->model->with(['comments', 'building', 'assignedUser']);
        return $filters->apply($query)->paginate($perPage);
    }

    public function findTaskById(string $id)
    {
        return $this->model->with(['comments', 'building', 'assignedUser'])->findOrFail($id);
    }

    public function createTask(array $data): Task
    {
        return $this->create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        return $this->update($task, $data);
    }

    public function deleteTask(Task $task): bool
    {
        return $this->delete($task);
    }
}
