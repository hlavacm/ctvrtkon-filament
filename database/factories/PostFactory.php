<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => $title = ucfirst($this->faker->unique()->words($this->faker->numberBetween(1, 4), true)),
            "slug" => Str::slug($title),
            "description" => $this->faker->boolean() ? $this->faker->sentence($this->faker->randomDigitNotNull) : null,
            "content" => $this->faker->sentences($this->faker->randomDigitNotNull, true),
            "published_at" => $this->faker->randomDigit() !== 0 ? $this->faker->dateTimeInInterval("-9 months", "+3 months") : null,
        ];
    }

    public function referenced()
    {
        $allUsers = User::get(["id"]);
        $allCategories = Category::get(["id"]);
        return $this->state(function (array $attributes) use ($allUsers, $allCategories) {
            return [
                "author_id" => $allUsers->random()->id,
                "category_id" => $allCategories->random()->id,
            ];
        });
    }
}
