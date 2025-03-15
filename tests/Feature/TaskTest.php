<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Building;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a task.
     */
    #[Test]
    public function it_can_create_a_task()
    {
        $user = User::factory()->create();
        $building = Building::factory()->create();

        $payload = [
            'title' => 'Fix elevator',
            'description' => 'Check and repair elevator system',
            'status' => 'Open',
            'assigned_user_id' => $user->id,
            'building_id' => $building->id
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'title' => 'Fix elevator',
                         'description' => 'Check and repair elevator system',
                         'status' => 'Open',
                         'assigned_user_id' => $user->id,
                         'building_id' => $building->id
                     ]
                 ]);

        $this->assertDatabaseHas('tasks', $payload);
    }

    /**
     * Test listing tasks.
     */
    #[Test]
    public function it_can_list_tasks()
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data') // Verifica que 3 tarefas foram retornadas
                 ->assertJsonFragment([
                     'title' => $tasks[0]->title,
                     'status' => $tasks[0]->status
                 ]);
    }

    /**
     * Test getting a single task.
     */
    #[Test]
    public function it_can_get_a_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $task->id,
                         'title' => $task->title,
                         'description' => $task->description,
                         'status' => $task->status,
                         'assigned_user_id' => $task->assigned_user_id,
                         'building_id' => $task->building_id
                     ]
                 ]);
    }

    /**
     * Test updating a task.
     */
    #[Test]
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $updatedData = [
            'title' => 'Updated Task Title',
            'description' => 'Updated Task Description',
            'status' => 'Completed'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $task->id,
                         'title' => 'Updated Task Title',
                         'description' => 'Updated Task Description',
                         'status' => 'Completed'
                     ]
                 ]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Task Title']);
    }

    /**
     * Test deleting a task.
     */
    #[Test]
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
