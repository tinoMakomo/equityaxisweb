<?php

namespace Database\Factories;

use App\Models\AdPreset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->paragraph(),
            'link' => $this->faker->url(),
            'preset' => $this->faker->randomElement(AdPreset::LIST),
        ];
    }
}
