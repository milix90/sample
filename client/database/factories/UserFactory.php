<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => "091" . rand(11111111, 9999999),
            'phone' => "01" . rand(111111111, 19999999),
            'password' => Hash::make("password"),
            'client_type' => "team",
            'username' => hexdec(uniqid()),
            'active' => true,
            'verify' => true,
        ];
    }
}
