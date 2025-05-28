<?php

namespace Database\Seeders;

use App\Models\FieldOfStudy;
use Illuminate\Database\Seeder;

class FieldOfStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldOfStudy::factory()
            ->count(5)
            ->create();
    }
}
