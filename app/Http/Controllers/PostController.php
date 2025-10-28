<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // 投稿一覧表示
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    // 新規投稿フォーム表示
    public function create()
    {
        return view('posts.create');
    }

    // 投稿保存処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'body' => 'required',
        ]);
        Post::create($request->only(['name', 'body']));
        return redirect()->route('posts.index');
    }
}
