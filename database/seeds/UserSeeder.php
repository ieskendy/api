<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,20) as $index) {
	        User::create([
	            'fname' => $faker->name,
	            'lname' => $faker->name,
	            'email' => $faker->email,
	            'about_me' => $faker->sentence,
	            'password' => bcrypt('secret')
	        ]);
        }
    }
}
