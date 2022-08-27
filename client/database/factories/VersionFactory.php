<?php

namespace Database\Factories;

use App\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionFactory extends Factory
{
    protected $model = Version::class;

    public function definition(): array
    {
        $vr = "1." . rand(1, 10);
        return [
            'version' => $vr,
            'app_file' => storage_path("/apps/first_user/version_1/$vr.zip"),
            'images' => [storage_path("/apps/first_user/version_1/images/1.jpg")],
            'change_log' => $this->faker->text(100),
            'status' => ['pending', 'in_progress'][rand(0, 1)],
        ];
    }
}
