<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title' => $this->faker->title(),
            'body' => $this->faker->paragraph(),
            'slug' => $this->faker->slug(),
            'user_id' => User::factory(),
            'permalink' => "",
            'status' => "published",
            'publish_at' => now(),
            'excerpt' => $this->faker->sentence(),
            'editors_pick' => $this->faker->boolean(),
            'tags' => implode(";;", $this->faker->words(3))
        ];
    }
}
