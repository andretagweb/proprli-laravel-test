<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $building = Building::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson('/api/tasks', [
            'title' => 'Fix elevator',
            'description' => 'Check and repair elevator system',
            'status' => 'Open',
            'assigned_user_id' => $user->id,
            'building_id' => $building->id
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Fix elevator']);
    }

    /** @test */
    public function it_can_list_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
