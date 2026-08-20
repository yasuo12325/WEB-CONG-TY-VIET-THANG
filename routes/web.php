<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/gioi-thieu', [PageController::class, 'about'])->name('about');
Route::get('/linh-vuc', [PageController::class, 'fields'])->name('fields');
Route::get('/cong-nghe', [PageController::class, 'technology'])->name('technology');
Route::get('/doi-tac', [PageController::class, 'partners'])->name('partners');

Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/du-an', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/du-an/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news.index');
Route::get('/tin-tuc/{news}', [NewsController::class, 'show'])->name('news.show');

Route::get('/lien-he', [ContactController::class, 'show'])->name('contact.show');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');
