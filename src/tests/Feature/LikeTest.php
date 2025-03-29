<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Condition;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_a_product()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $this->actingAs($user)
            ->post('/item/' . $product->id . '/favorite')
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_unlike_a_product()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $product = Product::factory()->create(['condition_id' => $condition->id]);
        Favorite::factory()->create(['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)
            ->delete('/item/' . $product->id . '/favorite')
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}