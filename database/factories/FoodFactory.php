<?php

namespace Database\Factories;

use App\Helpers\TypesRand;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "description" => $this->faker->realText(),
            "ingredients" => join(",",[
                $this->faker->word(),
                $this->faker->word(),
                $this->faker->word()
            ]),
            "price" => $this->faker->biasedNumberBetween(10,30),
            "rate" => $this->faker->biasedNumberBetween(1,5),
            "types" => TypesRand::random()
        ];
    }
}
