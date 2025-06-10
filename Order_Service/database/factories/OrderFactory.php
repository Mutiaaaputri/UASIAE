<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),  // Asumsikan Anda memiliki User model
            'total_price' => $this->faker->randomFloat(2, 10, 100),
            'status' => $this->faker->randomElement(['pending', 'paid']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            OrderItem::factory(3)->create([
                'order_id' => $order->id
            ]);
        });
    }
}
