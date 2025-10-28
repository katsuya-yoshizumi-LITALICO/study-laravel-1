@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新規投稿</h1>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">本文</label>
            <textarea name="body" id="body" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">投稿</button>
    </form>
</div>
@endsection
