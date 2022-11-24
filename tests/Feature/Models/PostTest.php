<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_post()
    {
        $post = Post::factory()->create();

        $this->assertModelExists($post);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create();
        $data = Post::factory()->raw();

        $post->update($data);
        $this->assertDatabaseHas($post->getTable(), $data + $post->only('id'));
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create();
        $post->delete();

        $this->assertModelMissing($post);
    }

    /** @test */
    public function a_post_belongs_to_a_category()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Category::class, $post->category);
    }

    /** @test */
    public function a_post_belongs_to_a_author()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->author);
    }

    /** @test */
    public function a_post_can_have_many_comments()
    {
        $post = Post::factory()->hasComments(3)->create();

        $this->assertCount(3, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }
}
