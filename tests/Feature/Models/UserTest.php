<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create();

        $this->assertModelExists($user);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        $data = [
            'name'  => 'some new name',
            'email' => 'some.new@email.com',
        ];

        $user->update($data);
        $this->assertDatabaseHas($user->getTable(), $data + $user->only('id'));
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertModelMissing($user);
    }

    /** @test */
    public function a_user_can_have_many_posts()
    {
        $user = User::factory()->hasPosts(3)->create();

        $this->assertCount(3, $user->posts);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /** @test */
    public function a_user_can_have_many_comments()
    {
        $user = User::factory()->hasComments(3)->create();

        $this->assertCount(3, $user->comments);
        $this->assertInstanceOf(Comment::class, $user->comments->first());
    }
}
