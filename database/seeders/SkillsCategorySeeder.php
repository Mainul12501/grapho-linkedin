<?php

namespace Database\Seeders;

use App\Models\SkillsCategory;
use Illuminate\Database\Seeder;

class SkillsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SkillsCategory::factory()
            ->count(5)
            ->create();
    }
}
