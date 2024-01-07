<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => ucfirst($this->faker->unique()->words($this->faker->numberBetween(1, 4), true)),
        ];
    }

    public function referenced()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
