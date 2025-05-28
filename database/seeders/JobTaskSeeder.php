<?php

namespace Database\Seeders;

use App\Models\JobTask;
use Illuminate\Database\Seeder;

class JobTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobTask::factory()
            ->count(5)
            ->create();
    }
}
