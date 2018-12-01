<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            'code' => 'R01',
            'name' => 'Xiang Chu Restaurant',
            'country' => 'MALAYSIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'R02',
            'name' => 'Yuan Le Foodcourt',
            'country' => 'MALAYSIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'R03',
            'name' => 'Rasia Restaurant',
            'country' => 'MALAYSIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'R04',
            'name' => 'WAKi Dim Sum Restaurant',
            'country' => 'MALAYSIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'R05',
            'name' => 'Yuan Le Dim Sum',
            'country' => 'MALAYSIA',
        ]);

        DB::table('branches')->insert([
            'code' => 'F01',
            'name' => 'WAKi International Tower',
            'country' => 'MALAYSIA',
        ]);
    }
}
