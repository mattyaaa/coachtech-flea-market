<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Condition;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_comment()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $this->actingAs($user)
            ->post('/item/' . $product->id . '/comment', ['comment' => 'これはテストコメントです。'])
            ->assertStatus(302)
            ->assertSessionHas('success', 'コメントを送信しました。');

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'これはテストコメントです。',
        ]);
    }

    public function test_guest_cannot_add_comment()
    {
        $condition = Condition::factory()->create();
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $this->post('/item/' . $product->id . '/comment', ['comment' => 'これはテストコメントです。'])
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'comment' => 'これはテストコメントです。',
        ]);
    }

    public function test_comment_must_be_string()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $this->actingAs($user)
            ->post('/item/' . $product->id . '/comment', ['comment' => 12345])
            ->assertSessionHasErrors('comment');

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'comment' => 12345,
        ]);
    }

    public function test_comment_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $product = Product::factory()->create(['condition_id' => $condition->id]);

        $this->actingAs($user)
            ->post('/item/' . $product->id . '/comment', ['comment' => str_repeat('a', 256)])
            ->assertSessionHasErrors('comment');

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'comment' => str_repeat('a', 256),
        ]);
    }
}