<?php

use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            'id' => "1",
            'name' => "Urgent"
        ]);

        DB::table('priorities')->insert([
            'id' => "2",
            'name' => "Important"
        ]);

        DB::table('priorities')->insert([
            'id' => "3",
            'name' => "Ignored"
        ]);

        DB::table('priorities')->insert([
            'id' => "4",
            'name' => "Optional"
        ]);
    }
}
