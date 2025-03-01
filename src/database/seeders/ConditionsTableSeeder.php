<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = [
            ['name' => '良好', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '目立った傷や汚れなし', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'やや傷や汚れあり', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '状態が悪い', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('conditions')->insert($conditions);
    }
}
