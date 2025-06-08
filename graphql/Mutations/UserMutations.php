<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserMutation
{
    public function createUser ($root, array $args)
    {
        $user = User::create([
            'name' => $args['input']['name'],
            'email' => $args['input']['email'],
            'password' => Hash::make($args['input']['password']),
            'role' => $args['input']['role'],
        ]);

        return $user;
    }
}
