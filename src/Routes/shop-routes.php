<?php

use Illuminate\Support\Facades\Route;
use Mziel\Blog\Http\Controllers\Shop\BlogController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'blog'], function () {
    Route::get('', [BlogController::class, 'index'])->name('shop.blog.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('shop.blog.show');
});

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'blog/category'], function () {
    Route::get('/{slug}', [BlogController::class, 'showCategory'])->name('shop.blog.category.show');
});
