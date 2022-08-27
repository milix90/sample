<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'name' => Str::snake($this->faker->title),
            'app_code' => Str::uuid(),
            'description' => $this->faker->text(100),
        ];
    }
}
