<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Profile;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_page_displays_correct_information()
    {
        // ユーザーとそのプロフィールを作成
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        // カテゴリと商品の状態を作成
        $category1 = Category::factory()->create(['name' => 'カテゴリ1']);
        $category2 = Category::factory()->create(['name' => 'カテゴリ2']);
        $condition = Condition::factory()->create(['name' => '新品']);

        // 商品を作成
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'description' => 'テスト商品説明',
            'price' => 1000,
            'brand' => 'テストブランド',
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);

        // カテゴリを商品に関連付け
        $product->categories()->attach([$category1->id, $category2->id]);

        // いいねを作成
        Favorite::factory()->create(['user_id' => $user->id, 'product_id' => $product->id]);

        // コメントを作成
        Comment::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'テストコメント'
        ]);

        // 商品詳細ページにアクセス
        $response = $this->get('/item/' . $product->id);

        // 必要な情報が表示されていることを確認
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テスト商品説明');
        $response->assertSee('¥1,000');
        $response->assertSee('テストブランド');
        $response->assertSee('新品');
        $response->assertSee('カテゴリ1');
        $response->assertSee('カテゴリ2');
        $response->assertSee('<span class="item-favorites-count">1</span>', false); // HTMLの一部として確認
        $response->assertSee('<span class="item-comments-count"><i class="fa-regular fa-comment"></i> 1</span>', false); // HTMLの一部として確認
        $response->assertSee('テストコメント');
        $response->assertSee($profile->name);  // コメントしたユーザー情報を確認
    }
}