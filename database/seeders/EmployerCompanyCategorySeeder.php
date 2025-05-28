<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployerCompanyCategory;

class EmployerCompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployerCompanyCategory::factory()
            ->count(5)
            ->create();
    }
}
