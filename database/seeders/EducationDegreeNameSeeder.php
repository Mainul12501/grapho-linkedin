<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationDegreeName;

class EducationDegreeNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationDegreeName::factory()
            ->count(5)
            ->create();
    }
}
