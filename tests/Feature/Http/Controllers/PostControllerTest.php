<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiIndex_投稿一覧を取得できること()
    {
        // Arrange: テストデータを作成
        Post::factory()->count(3)->create();

        // Act: APIエンドポイントにリクエスト
        $response = $this->getJson('/api/posts');

        // Assert: レスポンスを検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'body', 'created_at', 'updated_at']
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiIndex_投稿が新しい順に並んでいること()
    {
        // Arrange
        $oldPost = Post::factory()->create(['created_at' => now()->subDay()]);
        $newPost = Post::factory()->create(['created_at' => now()]);

        // Act
        $response = $this->getJson('/api/posts');

        // Assert
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertEquals($newPost->id, $data[0]['id']);
        $this->assertEquals($oldPost->id, $data[1]['id']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiStore_有効なデータで投稿を作成できること()
    {
        // Arrange
        $postData = [
            'title' => 'テストタイトル',
            'body' => 'テスト本文',
        ];

        // Act
        $response = $this->postJson('/api/posts', $postData);

        // Assert
        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'テストタイトル',
                'body' => 'テスト本文',
            ]);

        $this->assertDatabaseHas('posts', $postData);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiStore_titleが必須であること()
    {
        // Arrange
        $postData = [
            'body' => 'テスト本文',
        ];

        // Act
        $response = $this->postJson('/api/posts', $postData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiStore_bodyが必須であること()
    {
        // Arrange
        $postData = [
            'title' => 'テストタイトル',
        ];

        // Act
        $response = $this->postJson('/api/posts', $postData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['body']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiStore_titleが255文字を超えるとエラーになること()
    {
        // Arrange
        $postData = [
            'title' => str_repeat('あ', 256),
            'body' => 'テスト本文',
        ];

        // Act
        $response = $this->postJson('/api/posts', $postData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiStore_CORSヘッダーが設定されていること()
    {
        // Arrange
        $postData = [
            'title' => 'テストタイトル',
            'body' => 'テスト本文',
        ];

        // Act
        $response = $this->postJson('/api/posts', $postData);

        // Assert
        $response->assertStatus(201)
            ->assertHeader('Access-Control-Allow-Origin')
            ->assertHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function apiStore_OPTIONSリクエストでプリフライトに応答すること()
    {
        // Act
        $response = $this->json('OPTIONS', '/api/posts');

        // Assert
        $response->assertStatus(204)
            ->assertHeader('Access-Control-Allow-Origin')
            ->assertHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->assertHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }
}
