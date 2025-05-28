<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployerCompany;

class EmployerCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployerCompany::factory()
            ->count(5)
            ->create();
    }
}
