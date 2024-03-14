<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = \Faker\Factory::create();

        if(\DB::table('users')->where('email','superadmin@indihealth.com')->count() > 0)
        {
        	return "Akun Sudah didaftarkan";
        }
        \DB::table('users')->insert([ [
                  'name' => $faker->name,
                  'email' => 'superadmin@indihealth.com',
                  'role_id' => 1,
                  'password' => Hash::make('idhMonitoring@123#'),
                ]]);
    }
}
