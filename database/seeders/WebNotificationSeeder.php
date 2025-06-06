<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebNotification;

class WebNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebNotification::factory()
            ->count(5)
            ->create();
    }
}
