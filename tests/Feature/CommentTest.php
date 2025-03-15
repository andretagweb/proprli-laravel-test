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

        $payload = [
            'user_id' => $user->id,
            'content' => 'This task is now in progress.',
        ];

        $response = $this->postJson("/api/tasks/{$task->id}/comments", $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'task_id' => $task->id,
                         'user_id' => $user->id,
                         'content' => 'This task is now in progress.'
                     ]
                 ]);

        $this->assertDatabaseHas('comments', $payload);
    }

    /**
     * Test listing comments.
     */
    #[Test]
    public function it_can_list_comments()
    {
        $task = Task::factory()->create();
        $comments = Comment::factory()->count(2)->create(['task_id' => $task->id]);

        $response = $this->getJson("/api/tasks/{$task->id}/comments");

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data') 
                 ->assertJsonFragment([
                     'task_id' => $task->id,
                     'content' => $comments[0]->content
                 ]);
    }

    /**
     * Test getting a single comment.
     */
    #[Test]
    public function it_can_get_a_single_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->getJson("/api/tasks/{$comment->task_id}/comments/{$comment->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $comment->id,
                         'task_id' => $comment->task_id,
                         'user_id' => $comment->user_id,
                         'content' => $comment->content,
                     ]
                 ]);
    }

    /**
     * Test updating a comment.
     */
    #[Test]
    public function it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();

        $updatedContent = ['content' => 'Updated comment text.'];

        $response = $this->putJson("/api/tasks/{$comment->task_id}/comments/{$comment->id}", $updatedContent);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $comment->id,
                         'content' => 'Updated comment text.'
                     ]
                 ]);

        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'content' => 'Updated comment text.']);
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
