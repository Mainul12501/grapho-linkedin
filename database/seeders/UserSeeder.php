<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::insert([
            [
                'id' => 1,
                'name'  => 'Super Admin',
                'email' => 'admin@admin.com',
                'user_type' => 'super_admin',
//                'mobile' => '01911522517',
                'password'  => Hash::make('admin@admin.com'), // superadmin
//                'status'    => 1
            ],
            [
                'id' => 2,
                'name'  => 'Developer',
                'email' => 'developer@grapho.com',
                'user_type' => 'super_admin',
//                'mobile' => '01646688970',
                'password'  => Hash::make('mainulislam'), // superadmin
//                'status'    => 1
            ],
        ]);
//        $user->roles()->sync([1]);
    }
}
