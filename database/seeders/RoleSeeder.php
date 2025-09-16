<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'gudang', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'purchasing', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('roles')->insert($roles);
    }
}