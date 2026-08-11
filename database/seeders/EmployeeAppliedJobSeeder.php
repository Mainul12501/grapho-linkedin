<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeAppliedJob;

class EmployeeAppliedJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeAppliedJob::factory()
            ->count(5)
            ->create();
    }
}
