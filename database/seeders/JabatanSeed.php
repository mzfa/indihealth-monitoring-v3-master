<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JabatanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Jabatan
         \DB::table('jabatan')->insert([
            ['nama' => 'Web Programmer','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'Mobile Programmer','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'Staff HR','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'CTO','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'CEO','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'Direktur','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'Project Manager','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'System Analyst','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'Server Administrator','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'Marketing','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
            ['nama' => 'IoT Developer','created_at' => date('Y-m-d H:m:s'),'updated_by' => 0],
        ]);
    }
}
