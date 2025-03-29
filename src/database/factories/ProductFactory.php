<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomNumber(2),
            'status' => 'available',
            'user_id' => \App\Models\User::factory(),
            'condition_id' => 1,
            'image' => $this->faker->imageUrl(),
        ];
    }
}