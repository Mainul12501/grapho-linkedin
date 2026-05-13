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
                'name'  => 'Developer',
                'email' => 'developer@likewisebd.com',
                'user_type' => 'super_admin',
//                'mobile' => '01911522517',
                'password'  => Hash::make('developer@likewisebd.com'), // developer@likewisebd.com
//                'status'    => 1
            ],
            [
                'id' => 2,
                'name'  => 'Super Admin',
                'email' => 'likewisebd2025@gmail.com',
                'user_type' => 'super_admin',
//                'mobile' => '01646688970',
                'password'  => Hash::make('likewise.bd.%%2025'), // superadmin
//                'status'    => 1
            ],
        ]);
//        $user->roles()->sync([1]);
    }
}
