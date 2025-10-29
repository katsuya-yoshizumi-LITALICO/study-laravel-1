<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * 投稿一覧を表示する
     *
     * @return \Illuminate\View\View 投稿一覧ビュー
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * 新規投稿フォームを表示する
     *
     * @return \Illuminate\View\View 投稿フォームビュー
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * 投稿を保存する
     *
     * @param \Illuminate\Http\Request $request リクエストオブジェクト
     * @return \Illuminate\Http\RedirectResponse 投稿一覧へのリダイレクト
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'body' => 'required',
        ]);
        Post::create($request->only(['name', 'body']));
        return redirect()->route('posts.index');
    }

    /**
     * @api {get} /api/posts 投稿一覧取得
     * @apiName GetPosts
     * @apiGroup Posts
     * @apiSuccess {Object[]} posts 投稿データ
     * @apiSuccess {Number} posts.id 投稿ID
     * @apiSuccess {String} posts.name 投稿者名
     * @apiSuccess {String} posts.body 本文
     * @apiSuccess {String} posts.created_at 投稿日時
     */
    public function apiIndex()
    {
        return response()->json(Post::orderBy('created_at', 'desc')->get());
    }

    /**
     * 投稿を保存する
     *
     * @param \Illuminate\Http\Request $request リクエストオブジェクト
     * @return \Illuminate\Http\JsonResponse 保存結果のJSON
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'body' => 'required',
        ]);
        $post = Post::create($request->only(['name', 'body']));
        return response()->json($post, 201);
    }
}
