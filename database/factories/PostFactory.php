<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 * @method $this hasComments(...$params)
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'title'       => fake()->sentence,
            'slug'        => fake()->slug,
            'excerpt'     => '<p>' . implode('<p></p>', fake()->paragraphs(2)) . '</p>',
            'body'        => '<p>' . implode('<p></p>', fake()->paragraphs(6)) . '</p>',
        ];
    }
}
