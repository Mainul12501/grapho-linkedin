<?php

namespace Database\Seeders;

use App\Models\UniversityName;
use Illuminate\Database\Seeder;

class UniversityNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UniversityName::factory()
            ->count(5)
            ->create();
    }
}
