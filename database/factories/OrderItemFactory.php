<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'product_id' => \App\Models\Product::factory(), // PERBAIKI INI
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
