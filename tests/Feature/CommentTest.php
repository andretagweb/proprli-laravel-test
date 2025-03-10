<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a comment.
     */
    #[Test]
    public function it_can_create_a_comment()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->postJson("/api/tasks/{$task->id}/comments", [
            'user_id' => $user->id,
            'content' => 'This task is now in progress.'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'task_id', 'user_id', 'content']);

        $this->assertDatabaseHas('comments', ['content' => 'This task is now in progress.']);
    }

    /**
     * Test listing comments.
     */
    #[Test]
    public function it_can_list_comments()
    {
        $task = Task::factory()->create();
        Comment::factory()->count(2)->create(['task_id' => $task->id]);

        $response = $this->getJson("/api/tasks/{$task->id}/comments");

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    /**
     * Test updating a comment.
     */
    #[Test]
    public function it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->putJson("/api/tasks/{$comment->task_id}/comments/{$comment->id}", [
            'content' => 'Updated comment text.'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['content' => 'Updated comment text.']);

        $this->assertDatabaseHas('comments', ['content' => 'Updated comment text.']);
    }

    /**
     * Test deleting a comment.
     */
    #[Test]
    public function it_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$comment->task_id}/comments/{$comment->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
