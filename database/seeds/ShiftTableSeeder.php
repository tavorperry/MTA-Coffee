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
            //station 1
            [
                'station_id' => '1',
                'day' => '1',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '1',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '2',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '2',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '3',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '3',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '4',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '4',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '5',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '1',
                'day' => '5',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //station 2
            [
                'station_id' => '2',
                'day' => '1',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '1',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '2',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '2',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '3',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '3',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //
            [
                'station_id' => '2',
                'day' => '4',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '4',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '5',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '2',
                'day' => '5',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //station 3
            [
                'station_id' => '3',
                'day' => '1',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '1',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '2',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '2',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '3',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '3',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '4',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '4',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '5',
                'start_shift' => '8',
                'end_shift' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'station_id' => '3',
                'day' => '5',
                'start_shift' => '14',
                'end_shift' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];


        DB::table('shifts')->insert($shifts);
    }
}
