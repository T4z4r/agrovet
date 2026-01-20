<?php

namespace Database\Factories;

use App\Models\CommonCategory;
use App\Models\CommonProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommonProduct>
 */
class CommonProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommonProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = ['piece', 'kg', 'liter', 'pack', 'box', 'bottle', 'tube', 'can'];
        $costPrice = $this->faker->randomFloat(2, 1, 100);

        return [
            'name' => $this->faker->unique()->words(2, true),
            'unit' => $this->faker->randomElement($units),
            'default_cost_price' => $costPrice,
            'default_selling_price' => $costPrice * $this->faker->randomFloat(2, 1.2, 2.5),
            'common_category_id' => CommonCategory::factory(),
            'default_minimum_quantity' => $this->faker->numberBetween(5, 50),
            'barcode' => $this->faker->optional(0.8)->unique()->ean13(),
            'description' => $this->faker->optional(0.6)->sentence(),
            'is_active' => $this->faker->boolean(85), // 85% chance of being active
        ];
    }
}