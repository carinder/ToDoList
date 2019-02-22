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
            ['name' => 'urgent', 'weight' => 1],
            ['name' => 'important', 'weight' => 2],
            ['name' => 'ignored', 'weight' => 3],
            ['name' => 'optional', 'weight' => 4]
        ]);
    }
}
