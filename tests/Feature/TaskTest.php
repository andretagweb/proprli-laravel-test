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

        $response = $this->postJson('/api/tasks', [
            'title' => 'Fix elevator',
            'description' => 'Check and repair elevator system',
            'status' => 'Open',
            'assigned_user_id' => $user->id,
            'building_id' => $building->id
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'title', 'status']);

        $this->assertDatabaseHas('tasks', ['title' => 'Fix elevator']);
    }

    /**
     * Test listing tasks.
     */
    #[Test]
    public function it_can_list_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
