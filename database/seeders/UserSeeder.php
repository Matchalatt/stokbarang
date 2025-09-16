<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari ID dari role 'admin'
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        // 2. Buat user admin
        if ($adminRoleId) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
                'role_id' => $adminRoleId,
                'approve' => true, // Akun admin langsung berstatus approve
            ]);
        }
    }
}