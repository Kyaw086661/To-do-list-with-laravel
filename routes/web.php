<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route::get('/',[PostController::class, 'createPage'])->name('post#home');
Route::redirect('/', 'create/page')->name('post#home');
Route::get('create/page',[PostController::class, 'createPage'])->name('post#createPage');
Route::post('post/create',[PostController::class, 'postCreate'])->name('post#create');
Route::get('post/delete/{id}',[PostController::class,'postDelete'])->name('post#delete');
// Route::delete('post/delete/{id}',[PostController::class,'postDelete'])->name('post#delete');// change in create blade
Route::get('update/page/{id}',[PostController::class,'updatePage'])->name('post#updatePage');
Route::get('edit/page/{id}',[PostController::class,'editPage'])->name('post#editPage');
Route::post('post/update',[PostController::class,'update'])->name('post#update');
