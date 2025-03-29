<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    public function test_partial_match_search_by_product_name()
    {
        // 商品を作成するユーザーを作成
        $productUser = User::factory()->create();

        // 商品を作成
        Product::factory()->create(['name' => '赤いシャツ', 'user_id' => $productUser->id]);
        Product::factory()->create(['name' => '青いシャツ', 'user_id' => $productUser->id]);
        Product::factory()->create(['name' => '緑のシャツ', 'user_id' => $productUser->id]);

        // 検索を実行する別のユーザーを作成
        $searchUser = User::factory()->create();

        // 検索キーワードを入力して検索
        $response = $this->actingAs($searchUser)->get('/?search=シャツ');

        // 部分一致する商品が表示されることを確認
        $response->assertStatus(200);
        $response->assertSee('赤いシャツ');
        $response->assertSee('青いシャツ');
        $response->assertSee('緑のシャツ');
    }
}