<?php

use Illuminate\Database\Seeder;

class subscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscribers')->insert([
            'name' => "first_subscriber",
            'email' => 'first_subscriber@gmail.com',
        ]);
    }
}
