<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Topic;
class TopicSeeder extends Seeder
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
	        Topic::create([
	            'user_id' => $faker->numberBetween(1,20),
	            'title' => $faker->sentence,
	            'content' => $faker->paragraph
	        ]);
        }
    }
}
