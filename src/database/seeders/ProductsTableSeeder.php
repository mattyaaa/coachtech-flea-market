<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => '腕時計',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => 'images/ArmaniMensClock.jpg',
                'category' => 'ファッション',
                'condition' => '良好',
                'price' => 15000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 2,
                'name' => 'HDD',
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'images/HDDHardDisk.jpg',
                'category' => '家電',
                'condition' => '目立った傷や汚れなし',
                'price' => 5000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 3,
                'name' => '玉ねぎ3束',
                'description' => '新鮮な玉ねぎ3束のセット',
                'image' => 'images/iLoveIMGd.jpg',
                'category' => '食品',
                'condition' => 'やや傷や汚れあり',
                'price' => 300.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 4,
                'name' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'image' => 'images/LeatherShoesProductPhoto.jpg',
                'category' => 'ファッション',
                'condition' => '状態が悪い',
                'price' => 4000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'image' => 'images/LivingRoomLaptop.jpg',
                'category' => '家電',
                'condition' => '良好',
                'price' => 45000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 2,
                'name' => 'マイク',
                'description' => '高音質のレコーディング用マイク',
                'image' => 'images/MusicMic4632231.jpg',
                'category' => '家電',
                'condition' => '目立った傷や汚れなし',
                'price' => 8000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 3,
                'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'images/PurseFashionPocket.jpg',
                'category' => 'ファッション',
                'condition' => 'やや傷や汚れあり',
                'price' => 3500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 4,
                'name' => 'タンブラー',
                'description' => '使いやすいタンブラー',
                'image' => 'images/TumblerSouvenir.jpg',
                'category' => 'キッチン',
                'condition' => '状態が悪い',
                'price' => 500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => 'コーヒーミル',
                'description' => '手動のコーヒーミル',
                'image' => 'images/WaitressWithCoffeeGrinder.jpg',
                'category' => 'キッチン',
                'condition' => '良好',
                'price' => 4000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'condition_id' => 2,
                'name' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'image' => 'images/MakeupSet.jpg',
                'category' => '美容',
                'condition' => '目立った傷や汚れなし',
                'price' => 2500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
