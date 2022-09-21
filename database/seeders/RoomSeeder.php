<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert(
	    	[
	            [
	            	'room_name' => "Room 100",
		            'room_description' => "Room 100",
		            'active' => 1
	            ],
	            [
	            	'room_name' => "Room 101",
		            'room_description' => "Room 101",
		            'active' => 1
	            ],
	            [
	            	'room_name' => "Room 102",
		            'room_description' => "Room 102",
		            'active' => 1
	            ]
	        ]
    	);
    }
}
