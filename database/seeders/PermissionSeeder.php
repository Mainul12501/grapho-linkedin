<?php

namespace Database\Seeders;

use App\Models\Backend\RoleManagement\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Permission::factory()
//            ->count(5)
//            ->create();

        Permission::insert([
            [
                'id' => 1,
                'permission_category_id'  => 1,
                'title'  => 'Super Admin Dashboard',
                'slug'  => 'super-admin-dashboard',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 2,
                'permission_category_id'  => 1,
                'title'  => 'Admin Dashboard',
                'slug'  => 'admin-dashboard',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 3,
                'permission_category_id'  => 1,
                'title'  => 'Normal User Dashboard',
                'slug'  => 'normal-user-dashboard',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 4,
                'permission_category_id'  => 2,
                'title'  => 'Manage Permission Category',
                'slug'  => 'manage-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 5,
                'permission_category_id'  => 2,
                'title'  => 'Create Permission Category',
                'slug'  => 'create-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 6,
                'permission_category_id'  => 2,
                'title'  => 'Store Permission Category',
                'slug'  => 'store-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 7,
                'permission_category_id'  => 2,
                'title'  => 'Edit Permission Category ',
                'slug'  => 'edit-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 8,
                'permission_category_id'  => 2,
                'title'  => 'Update Permission Category',
                'slug'  => 'update-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 9,
                'permission_category_id'  => 2,
                'title'  => 'Show Permission Category',
                'slug'  => 'show-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 10,
                'permission_category_id'  => 2,
                'title'  => 'Delete Permission Category',
                'slug'  => 'delete-permission-category',
                'status'    => 1,
                'is_default'    => 1,
            ],

            //      ================ Permission ===========
            [
                'id' => 11,
                'permission_category_id'  => 2,
                'title'         => 'Manage Permission',
                'slug'          => 'manage-permission',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 12,
                'permission_category_id'  => 2,
                'title'         => 'Create Permission',
                'slug'          => 'create-permission',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 13,
                'permission_category_id'  => 2,
                'title'         => 'Store Permission ',
                'slug'          => 'store-permission',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 14,
                'permission_category_id'  => 2,
                'title'         => 'Edit Permission',
                'slug'          => 'edit-permission',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 15,
                'permission_category_id'  => 2,
                'title'         => 'Update Permission',
                'slug'          => 'update-permission',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 16,
                'permission_category_id'  => 2,
                'title'         => 'Show Permission',
                'slug'          => 'show-permission',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 17,
                'permission_category_id'  => 2,
                'title'  => 'Delete Permission',
                'slug'  => 'delete-permission',
                'status'    => 1,
                'is_default'    => 1,
            ],

//      ================ Role ===========
            [
                'id' => 18,
                'permission_category_id'  => 3,
                'title'       => 'Manage Role',
                'slug'        => 'manage-role',
                'status'      => 1,
                'is_default'  => 1,
            ],
            [
                'id' => 19,
                'permission_category_id'  => 3,
                'title'      => 'Create Role',
                'slug'       => 'create-role',
                'status'     => 1,
                'is_default' => 1,
            ],
            [
                'id' => 20,
                'permission_category_id'  => 3,
                'title'         => 'Store Role ',
                'slug'          => 'store-role',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 21,
                'permission_category_id'  => 3,
                'title'         => 'Edit Role',
                'slug'          => 'edit-role',
                'status'        => 1,
                'is_default'    => 1,
            ],
            [
                'id' => 22,
                'permission_category_id'  => 3,
                'title'       => 'Update Role',
                'slug'        => 'update-role',
                'status'      => 1,
                'is_default'  => 1,
            ],
            [
                'id' => 23,
                'permission_category_id'  => 3,
                'title'       => 'Show Role',
                'slug'        => 'show-role',
                'status'      => 1,
                'is_default'  => 1,
            ],
            [
                'id' => 24,
                'permission_category_id'  => 3,
                'title'       => 'Delete Role',
                'slug'        => 'delete-role',
                'status'      => 1,
                'is_default'  => 1,
            ],
// ================ User Role =================

        ]);
    }
}
