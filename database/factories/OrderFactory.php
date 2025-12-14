<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statusOptions = ['pending', 'completed', 'cancelled'];

        return [
            'order_number' => strtoupper(Str::random(10)),
            'subtotal' => $this->faker->numberBetween(30, 600),
            'total' => $this->faker->numberBetween(20, 500),
            'status' => $this->faker->randomElement($statusOptions),
        ];
    }
}
