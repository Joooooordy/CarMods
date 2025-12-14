<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $methods = ['credit_card', 'paypal', 'bank_transfer'];
        $statuses = ['pending', 'completed', 'failed'];

        return [
            'amount' => $this->faker->numberBetween(20, 500),
            'currency' => 'EUR',
            'status' => $this->faker->randomElement($statuses),
            'payment_method' => $this->faker->randomElement($methods),
            'paid_at' => $this->faker->dateTime(),
            'metadata' => json_encode(['transaction_id' => Str::uuid()]),
        ];
    }
}
