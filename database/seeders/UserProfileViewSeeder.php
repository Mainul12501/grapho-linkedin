<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfileView;

class UserProfileViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProfileView::factory()
            ->count(5)
            ->create();
    }
}
