<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            'user_id' => rand(10),
            'game_id' => rand(10),
            'score' => rand(0, 100) / 10, // for making floating point
        ]);
    }
}
