<?php

use Illuminate\Support\Facades\Route;
use Mziel\Blog\Http\Controllers\Admin\BlogController;
use Mziel\Blog\Http\Controllers\Admin\BlogCategoryController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/blog'], function () {
    Route::controller(BlogController::class)->group(function () {
        Route::get('', 'index')->name('admin.blog.index');
        Route::get('create', 'create')->name('admin.blog.create');
        Route::post('store', 'store')->name('admin.blog.store');
        Route::get('edit/{id}', 'edit')->name('admin.blog.edit');
        Route::put('update/{id}', 'update')->name('admin.blog.update');
        Route::delete('delete/{id}', 'destroy')->name('admin.blog.delete');
        Route::post('mass-delete', 'massDelete')->name('admin.blog.mass_delete');
    });
});

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/blog/categories'], function () {
    Route::controller(BlogCategoryController::class)->group(function () {
        Route::get('', 'index')->name('admin.blog.category.index');
        Route::get('create', 'create')->name('admin.blog.category.create');
        Route::post('store', 'store')->name('admin.blog.category.store');
        Route::get('edit/{id}', 'edit')->name('admin.blog.category.edit');
        Route::put('update/{id}', 'update')->name('admin.blog.category.update');
        Route::delete('delete/{id}', 'destroy')->name('admin.blog.category.delete');
    });
});
