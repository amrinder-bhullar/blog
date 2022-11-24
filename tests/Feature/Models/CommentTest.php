<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_comment()
    {
        $comment = Comment::factory()->create();

        $this->assertModelExists($comment);
    }

    /** @test */
    public function it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();
        $data = Comment::factory()->raw();

        $comment->update($data);
        $this->assertDatabaseHas($comment->getTable(), $data + $comment->only('id'));
    }

    /** @test */
    public function it_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();
        $comment->delete();

        $this->assertModelMissing($comment);
    }

    /** @test */
    public function a_comment_belongs_to_a_post()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(Post::class, $comment->post);
    }

    /** @test */
    public function a_comment_belongs_to_a_author()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(User::class, $comment->author);
    }
}
