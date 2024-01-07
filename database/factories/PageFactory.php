<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => $title = ucfirst($this->faker->unique()->words($this->faker->numberBetween(1, 4), true)),
            "slug" => Str::slug($title),
            "description" => $this->faker->boolean() ? $this->faker->sentence($this->faker->randomDigitNotNull) : null,
            "content" => $this->faker->sentences($this->faker->randomDigitNotNull, true),
            "is_active" => $this->faker->boolean(),
        ];
    }

    public function referenced()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
