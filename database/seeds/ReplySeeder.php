<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Reply;
class ReplySeeder extends Seeder
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
	        Reply::create([
	            'user_id' => $faker->numberBetween(1,20),
	            'topic_id'=> $faker->numberBetween(1,20),
	            'content' => $faker->paragraph
	        ]);
        }
    }
}
