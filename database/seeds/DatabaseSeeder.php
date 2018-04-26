<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TopicSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ReplySeeder::class);
        $this->call(CategorySeeder::class);
    }
}
