<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobLocationType;

class JobLocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobLocationType::factory()
            ->count(5)
            ->create();
    }
}
