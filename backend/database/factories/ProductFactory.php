<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    private const CATEGORIES = ['Frozen', 'Chilled', 'Dry Goods', 'Packaging', 'Ingredients'];

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(self::CATEGORIES),
        ];
    }
}
