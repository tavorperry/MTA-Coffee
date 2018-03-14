<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stations = [
            [
                'name' => 'Fomento',
                'building' => 1,
                'floor' => 2
            ],
            [
                'name' => 'Weston',
                'building' => 2,
                'floor' => 0
            ],
            [
                'name' => 'Kalkala',
                'building' => 3,
                'floor' => 2
            ]
        ];

        DB::table('stations')->insert($stations);
    }
}
