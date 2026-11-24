<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostController::class);

    Route::post('/posts/{id}/restore', [PostController::class, 'restore'])
        ->name('posts.restore');

});

require __DIR__.'/auth.php';