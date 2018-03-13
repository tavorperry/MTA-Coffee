<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [
            [
                'station_id' => rand(1, 3),
                'day' => '1',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => rand(1, 3),
                'day' => '1',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => rand(1, 3),
                'day' => '2',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => rand(1, 3),
                'day' => '2',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];


        DB::table('shifts')->insert($shifts);
    }
}
