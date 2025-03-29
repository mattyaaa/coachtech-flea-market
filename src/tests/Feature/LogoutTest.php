<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout()
    {
        // テスト用ユーザーを作成
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // ユーザーをログイン
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // ユーザーが認証されていることを確認
        $this->assertAuthenticatedAs($user);

        // ユーザーをログアウト
        $response = $this->post('/logout');

        // ユーザーがホームページにリダイレクトされることを確認
        $response->assertRedirect('/');

        // ユーザーがログアウトされていることを確認
        $this->assertGuest();
    }
}