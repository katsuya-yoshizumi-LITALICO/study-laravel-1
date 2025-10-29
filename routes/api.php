<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::group(['middleware' => ['api', 'cors']], function() {
    Route::get('/posts', [PostController::class, 'apiIndex']);
    Route::post('/posts', [PostController::class, 'apiStore']);
    Route::options('/posts', function () {
        return response('', 204);
    });
});
