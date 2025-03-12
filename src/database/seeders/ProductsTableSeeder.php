<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;


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
                'price' => 2500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
