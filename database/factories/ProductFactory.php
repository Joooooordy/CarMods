<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected static $productList = null;

    public function definition(): array
    {
        if (self::$productList === null) {
            $json = file_get_contents(config_path('products.json'));
            self::$productList = json_decode($json, true);
        }

        $product = fake()->unique()->randomElement(self::$productList);

        return [
            'name' => $product['name'],
            'description' => fake()->realText(400),
            'price' => $product['price'],
            'shipping_cost' => $product['shipping_cost'],
            'stock' => fake()->numberBetween(0, 100),
            'image' => fake()->imageUrl(400, 400, 'products', true),
        ];
    }
}
