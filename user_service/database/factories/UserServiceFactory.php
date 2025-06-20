<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'role' => 'user',
        ];
    }
}
