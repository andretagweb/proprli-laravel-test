<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_comment()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->postJson("/api/tasks/{$task->id}/comments", [
            'user_id' => $user->id,
            'content' => 'This task is now in progress.'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', ['content' => 'This task is now in progress.']);
    }
}
