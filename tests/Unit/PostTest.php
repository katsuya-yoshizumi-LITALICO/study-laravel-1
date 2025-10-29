<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Postモデルの作成テスト
     *
     * @return void
     */
    public function test_post_creation()
    {
        $post = Post::factory()->create([
            'name' => 'テストユーザー',
            'body' => 'テスト本文',
        ]);

        $this->assertDatabaseHas('posts', [
            'name' => 'テストユーザー',
            'body' => 'テスト本文',
        ]);
    }
}
