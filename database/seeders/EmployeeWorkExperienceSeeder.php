<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeWorkExperience;

class EmployeeWorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeWorkExperience::factory()
            ->count(5)
            ->create();
    }
}
