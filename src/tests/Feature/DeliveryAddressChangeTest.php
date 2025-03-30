<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Condition;

class DeliveryAddressChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_delivery_address_and_see_it_reflected()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        // Conditionデータを作成
        $condition = Condition::factory()->create();

        // Productデータを作成
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $newAddress = '新しい住所';
        $newPostalCode = '123-4567';
        $newBuildingName = '新しい建物名';

        // ログインして送付先住所変更画面に移動
        $response = $this->actingAs($user)
            ->get('/purchase/address/' . $product->id)
            ->assertStatus(200)
            ->assertSee('住所の変更');

        // 住所を変更
        $response = $this->actingAs($user)
            ->put('/purchase/address/' . $product->id, [
                'postal_code' => $newPostalCode,
                'address' => $newAddress,
                'building_name' => $newBuildingName,
            ])
            ->assertStatus(302)
            ->assertSessionHas('status', '住所が更新されました。');

        // 商品購入画面に移動して、新しい住所が反映されていることを確認
        $response = $this->actingAs($user)
            ->get('/purchase/' . $product->id)
            ->assertStatus(200)
            ->assertSee($newAddress)
            ->assertSee($newPostalCode)
            ->assertSee($newBuildingName);
    }

    public function test_purchase_with_new_address()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        // Conditionデータを作成
        $condition = Condition::factory()->create();

        // Productデータを作成
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $newAddress = '新しい住所';
        $newPostalCode = '123-4567';
        $newBuildingName = '新しい建物名';

        // 住所を変更
        $response = $this->actingAs($user)
            ->put('/purchase/address/' . $product->id, [
                'postal_code' => $newPostalCode,
                'address' => $newAddress,
                'building_name' => $newBuildingName,
            ])
            ->assertStatus(302)
            ->assertSessionHas('status', '住所が更新されました。');

        // 商品購入画面に移動して、新しい住所が反映されていることを確認
        $response = $this->actingAs($user)
            ->get('/purchase/' . $product->id)
            ->assertStatus(200)
            ->assertSee($newAddress)
            ->assertSee($newPostalCode)
            ->assertSee($newBuildingName);

        // 商品を購入
        $response = $this->actingAs($user)
            ->post('/purchase/' . $product->id, [
                '_token' => csrf_token(),
                'payment_method' => 'カード支払い',
            ])
            ->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('status', '購入手続きが完了しました。');

        // リダイレクト先でのエラーを確認
        $response = $this->get('/')
            ->assertStatus(200)
            ->assertSee('購入手続きが完了しました。');
    }
}