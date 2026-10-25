<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'code' => fake()->unique()->bothify('PRD-####'),
            'name' => fake()->words(2, true),
            'price' => fake()->randomFloat(2, 1000, 500000),
            'expired_date' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'supplier_name' => fake()->company(),
        ];
    }

    /**
     * Indicate that the product has already expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expired_date' => fake()->dateTimeBetween('-1 year', '-1 day')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the product has no expiration date.
     */
    public function withoutExpiredDate(): static
    {
        return $this->state(fn (array $attributes) => [
            'expired_date' => null,
        ]);
    }
}
