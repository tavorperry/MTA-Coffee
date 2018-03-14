<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shiftUser = [
            [
                'user_id' => 1,
                'shift_id' => rand(1,30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 1,
                'shift_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'shift_id' => rand(1,30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 3,
                'shift_id' => rand(1,30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ];

        DB::table('shift_user')->insert($shiftUser);
    }
}
