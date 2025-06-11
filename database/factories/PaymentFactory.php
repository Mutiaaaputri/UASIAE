<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // generate user otomatis
            'amount' => $this->faker->randomFloat(2, 10000, 100000000),
            'currency' => 'IDR',
            'method' => $this->faker->randomElement(['bank_transfer', 'gopay', 'ovo', 'credit_card']),
            'status' => $this->faker->randomElement(['pending', 'success', 'failed']),
            'transaction_id' => strtoupper(Str::random(12)),
        ];
    }
}
