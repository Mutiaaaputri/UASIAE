<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 1,
            'product_id' => 101,
            'quantity' => 2,
            'total_price' => 200000.00,
            'status' => 'COMPLETED',
        ]);

        Order::create([
            'user_id' => 1,
            'product_id' => 102,
            'quantity' => 1,
            'total_price' => 50000.00,
            'status' => 'PENDING',
        ]);

        Order::create([
            'user_id' => 2,
            'product_id' => 103,
            'quantity' => 5,
            'total_price' => 250000.00,
            'status' => 'PROCESSING',
        ]);
    }
}