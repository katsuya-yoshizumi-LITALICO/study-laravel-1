<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

// The API routes have been moved to api.php
// Route definitions for /api/posts are now managed there.

Route::get('/', function () {
    abort(404);
});
