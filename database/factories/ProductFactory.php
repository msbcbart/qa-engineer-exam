<?php

namespace Database\Factories;

use App\Enums\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'category' => fake()->randomElement(array_map(
                fn(ProductCategory $category) => $category->value, 
                ProductCategory::cases()
            )),
            'description' => fake()->realText(),
            'date_time' => fake()->dateTimeThisYear()
        ];
    }
}
