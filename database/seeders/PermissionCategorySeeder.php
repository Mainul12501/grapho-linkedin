<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\RoleManagement\PermissionCategory;

class PermissionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        PermissionCategory::factory()
//            ->count(5)
//            ->create();

        PermissionCategory::insert([
            [
                'id' => 1,
                'name'  => 'Dashboard',
                'slug'  => 'Dashboard',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 2,
                'name'  => 'Permission Management',
                'slug'  => 'permission-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 3,
                'name'  => 'Role Management',
                'slug'  => 'role-management',
                'note'  => '',
                'status'    => 1,
                'is_default'    => 1,
            ],
        ]);
    }
}
