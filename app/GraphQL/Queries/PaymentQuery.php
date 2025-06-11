<?php
namespace App\GraphQL\Queries;

use App\Models\Payment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PaymentQuery extends Query
{
    protected $attributes = [
        'name' => 'payments',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Payment'));
    }

    public function resolve($root, $args)
    {
        return Payment::all();
    }
}
