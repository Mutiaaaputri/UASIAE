<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\UserService;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        UserService::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
