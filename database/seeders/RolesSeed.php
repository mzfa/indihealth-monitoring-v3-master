<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \DB::table('roles')->insert([
            ['name' => "superadmin",'created_at' => date('Y-m-d H:m:s')],
            ['name' => "employee",'created_at' => date('Y-m-d H:m:s')],
            ['name' => "hrd",'created_at' => date('Y-m-d H:m:s')],
            ['name' => "owner",'created_at' => date('Y-m-d H:m:s')],
        ]);
    }
}
