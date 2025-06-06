<?php

namespace Database\Seeders;

use App\Models\Backend\RoleManagement\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Role::factory()
//            ->count(5)
//            ->create();
        Role::insert([
            [
                'id'            => 1,
                'title'         => 'Super Admin',
                'note'          => '',
                'slug'          => 'super-admin',
                'is_default'    => 1,
                'status'        =>  1
            ],
            [
                'id'            => 2,
                'title'         => 'Admin',
                'note'          => '',
                'slug'          => 'admin',
                'is_default'    => 1,
                'status'        =>  1
            ],
            [
                'id'            => 3,
                'title'         => 'Employee',
                'note'          => '',
                'slug'          => 'employee',
                'is_default'    => 1,
                'status'        =>  1
            ],
            [
                'id'            => 4,
                'title'         => 'Employer',
                'note'          => '',
                'slug'          => 'employer',
                'is_default'    => 1,
                'status'        =>  1
            ],

        ]);
    }
}
