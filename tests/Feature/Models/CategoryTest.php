<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_category()
    {
        $category = Category::factory()->create();

        $this->assertModelExists($category);
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $category = Category::factory()->create();
        $data = [
            'name' => 'some new name',
            'slug' => 'some-new-slug',
        ];

        $category->update($data);
        $this->assertDatabaseHas($category->getTable(), $data + $category->only('id'));
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $category = Category::factory()->create();
        $category->delete();

        $this->assertModelMissing($category);
    }

    /** @test */
    public function a_category_can_have_many_posts()
    {
        $category = Category::factory()->hasPosts(3)->create();

        $this->assertCount(3, $category->posts);
        $this->assertInstanceOf(Post::class, $category->posts->first());
    }
}
