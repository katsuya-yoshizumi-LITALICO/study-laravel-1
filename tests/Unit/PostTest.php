<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function titleが設定されていれば保存できること()
    {
        $post = Post::create([
            'title' => 'タイトルあり',
            'body' => '本文あり',
        ]);
        $this->assertDatabaseHas('posts', [
            'title' => 'タイトルあり',
            'body' => '本文あり',
        ]);
        $this->assertNotNull($post->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function titleが未設定だと保存できないこと()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Post::create([
            // 'title' => null, // title未設定
            'body' => '本文のみ',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function PostをIDで取得できること()
    {
        $post = Post::factory()->create();
        $found = Post::find($post->id);
        $this->assertNotNull($found);
        $this->assertEquals($post->title, $found->title);
        $this->assertEquals($post->body, $found->body);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function created_atでソートできること()
    {
        $old = Post::factory()->create(['created_at' => now()->subDay()]);
        $new = Post::factory()->create(['created_at' => now()]);
        $sorted = Post::orderBy('created_at', 'desc')->get();
        $this->assertEquals($new->id, $sorted->first()->id);
        $this->assertEquals($old->id, $sorted->last()->id);
    }
}
