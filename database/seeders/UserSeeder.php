<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
	    	[
	            [
	            	'name' => "John Smith",
		            'email' => "admin@gmail.com",
		            'password' =>  bcrypt("password"),
		            'role_id' => 1
	            ],
	            [
	            	'name' => "User 1",
		            'email' => "user1@gmail.com",
		            'password' => bcrypt("password"),
		            'role_id' => 2
	            ],
	            [
	            	'name' => "User 2",
		            'email' => "user2@gmail.com",
		            'password' => bcrypt("password"),
		            'role_id' => 2
	            ],
	        ]
    	);
    }
}
