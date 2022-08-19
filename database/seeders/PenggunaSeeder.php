<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'user',
            'name' => 'user',
            'posisi' => 'user',
            'foto' => '',
            'kodesite' => 'X',
            'password' => md5(123456789),
        ]);

        $user->assignRole('user');

        $admin = User::create([
            'username' => 'admin',
            'name' => 'admin',
            'posisi' => 'admin',
            'foto' => '',
            'kodesite' => 'X',
            'password' => md5(123456789),
        ]);

        $admin->assignRole('admin');


        $super_admin = User::create([
            'username' => 'super_admin',
            'name' => 'super_admin',
            'posisi' => 'super_admin',
            'foto' => '',
            'kodesite' => 'X',
            'password' => md5(123456789),
        ]);

        $super_admin->assignRole('super_admin');

        
    }
}
