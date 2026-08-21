<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Vietnamese (default) — unchanged from before bilingual support: same
| paths, same route names, so every existing route()/lr() call keeps
| working exactly as it did. Locale is resolved from the URL globally by
| App\Http\Middleware\SetLocale (registered in bootstrap/app.php), not by
| middleware here — that also covers 404s for URLs that match no route.
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| English — same controllers/actions, English URLs, route names mirror the
| Vietnamese ones 1:1 under an "en." prefix (see App\Support\lr() helper),
| so Blade views stay locale-agnostic instead of branching per language.
|--------------------------------------------------------------------------
*/
Route::prefix('en')->name('en.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/industries', [PageController::class, 'fields'])->name('fields');
    Route::get('/technology', [PageController::class, 'technology'])->name('technology');
    Route::get('/partners', [PageController::class, 'partners'])->name('partners');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});
