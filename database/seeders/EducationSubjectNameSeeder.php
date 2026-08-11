<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationSubjectName;

class EducationSubjectNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationSubjectName::factory()
            ->count(5)
            ->create();
    }
}
