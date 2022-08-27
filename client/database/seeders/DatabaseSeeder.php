<?php

namespace Database\Seeders;

use App\Models\Application as MyApp;
use App\Models\User;
use App\Models\Version;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create()->each(function ($user) {
            $user->applications()->saveMany(MyApp::factory()->count(2)->make())->each(function ($application) {
                $application->versions()->saveMany(Version::factory()->count(3)->make());
            });
        });
    }
}
