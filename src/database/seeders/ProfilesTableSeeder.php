<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1Id = DB::table('users')->where('email', 'testuser@example.com')->first()->id;
        $user2Id = DB::table('users')->where('email', 'testtaro@example.com')->first()->id;

        $profiles = [
            [
                'user_id' => $user1Id,
                'profile_image' => 'profile_images/images.png',
                'name' => 'Test User',
                'postal_code' => '1234567',
                'address' => 'Test Address',
                'building_name' => 'Test Building',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $user2Id,
                'profile_image' => 'profile_images/images2.jpg',
                'name' => 'テスト 太郎',
                'postal_code' => '7654321',
                'address' => 'Another Address',
                'building_name' => 'Another Building',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('profiles')->insert($profiles);
    }
}