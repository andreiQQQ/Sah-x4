<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::table('users')->insert([
            'email' => 'admin@sah.local',
            'password' => bcrypt('123456'),
        ]);
    }
}
