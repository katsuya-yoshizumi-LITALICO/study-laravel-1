<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

Route::get('/', function () {
	abort(404);
});

// API routes
Route::get('/api/posts', [PostController::class, 'apiIndex']);
Route::post('/api/posts', [PostController::class, 'apiStore']);
Route::options('/api/posts', function () {
	return response('', 204);
});

Route::get('/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/store', [PostController::class, 'store'])->name('posts.store');
