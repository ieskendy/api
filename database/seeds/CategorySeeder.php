<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,5) as $index) {
	        Category::create([
	            'category_name' => $faker->sentence
	        ]);
        }
    }
}
