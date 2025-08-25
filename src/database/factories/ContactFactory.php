<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name'  => $this->faker->firstName(),
            'last_name'   => $this->faker->lastName(),
            'gender'      => $this->faker->randomElement(['男性', '女性', 'その他']),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'        => $this->faker->phoneNumber(),
            'address'     => $this->faker->address(),
            'category_id' => $this->faker->numberBetween(1, 5), // CategorySeederのID範囲
            'detail'      => $this->faker->realText(100),
        ];
    }
}