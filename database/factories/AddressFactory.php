<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'street'     => $this->faker->streetName(),
            'house_nr'   => $this->faker->buildingNumber(),
            'zipcode'    => $this->faker->postcode(),
            'city'       => $this->faker->city(),
            'state'      => $this->faker->state(),
            'country'    => $this->faker->country(),
        ];
    }
}
