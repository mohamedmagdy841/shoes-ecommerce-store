<?php

namespace Database\Factories;


use App\Models\Category;
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
            'name' => $this->faker->sentence(2),
            'brand' => $this->faker->randomElement(['Adidas', 'Nike', 'Puma', 'New Balance']),
            'price' => $this->faker->numberBetween(50, 200),
            'qty' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->text(),
            'color' => $this->faker->colorName(),
            'width' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 300),
            'depth' => $this->faker->numberBetween(50, 100),
            'weight' => $this->faker->numberBetween(50, 100),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
