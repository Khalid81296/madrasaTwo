<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BloodGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blood_groups')->delete();
        echo rand(1,50);
        $books = [
            'name' => 'bangla',
            'my_class_id' => rand(1,50),
            'description' => 'bangla bangla bangla',
            'author' => 'bangla',
            'name' => 'bangla',
            'name' => 'bangla',
            'name' => 'bangla',
            'name' => 'bangla',
        ];

        // id	name	my_class_id	description	author	book_type	url	location	total_copies	issued_copies	created_at	updated_at


        $bgs = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
        foreach($bgs as  $bg){
            BloodGroup::create(['name' => $bg]);
        }
    }

}
