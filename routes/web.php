<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::get('/', [BasicController::class, 'index'])->name('home');
Route::get('/about', [BasicController::class, 'about'])->name('about');
Route::get('/contact', [BasicController::class, 'contact'])->name('contact');
Route::post('/contact', [BasicController::class, 'contactStore'])->name('contact.store');

Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');


Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');


Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news/{news:slug}/edit', [NewsController::class, 'edit'])->name('news.edit');
Route::put('/news/{news:slug}', [NewsController::class, 'update'])->name('news.update');
Route::delete('/news/{news:slug}', [NewsController::class, 'destroy'])->name('news.destroy');

Route::post('/news/{id}/like', [LikeController::class, 'toggleLike'])->name('news.like');

Route::get('/category/{category}', [NewsController::class, 'category'])->name('news.category');

Route::middleware('auth')->group(function () {
    Route::post('/news/{newsId}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/news/{id}/save', [NewsController::class, 'save'])->name('news.save');
    Route::delete('/news/{id}/unsave', [NewsController::class, 'unsave'])->name('news.unsave');
    Route::delete('/profile/history/clear', [DashboardController::class, 'clearHistory'])->name('profile.history.clear');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
});

Route::prefix('admin')
    ->middleware(['auth', 'role:admin|helper'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.role');
        Route::get('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contacts.index');
        Route::get('/contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('admin.contacts.show');
        Route::patch('/contacts/{contact}/status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('admin.contacts.status');
        Route::patch('/contacts/{contact}/mark-as-read', [\App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('admin.contacts.mark-read');
    });

require __DIR__.'/auth.php';