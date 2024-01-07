<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => $title = ucfirst($this->faker->unique()->words($this->faker->numberBetween(1, 4), true)),
            "slug" => Str::slug($title),
            "description" => $this->faker->boolean() ? $this->faker->sentence($this->faker->randomDigitNotNull) : null,
        ];
    }

    public function referenced()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
