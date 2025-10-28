@extends('layouts.app')

@section('content')
<div class="container">
    <h1>掲示板</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>
    @foreach ($posts as $post)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ $post->name }}</h5>
                <p class="card-text">{{ $post->body }}</p>
                <small class="text-muted">{{ $post->created_at }}</small>
            </div>
        </div>
    @endforeach
</div>
@endsection
