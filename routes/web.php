<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\ProductPerformanceReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{id}/delete', [PostController::class, 'delete'])->name('posts.delete');

Route::prefix('/api')->group(function() {
    Route::get('/posts', [ApiPostController::class, 'index'])->name('api.posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('api.posts.show');
});

Route::any('/reports/product-performance', [ProductPerformanceReportController::class, 'index'])->name('reports.product_performance');
Route::any('/reports/product-performance-def', [ProductPerformanceReportController::class, 'deferred'])->name('reports.product_performance.def');
