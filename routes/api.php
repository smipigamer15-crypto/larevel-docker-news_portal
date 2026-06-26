<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;


Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);
Route::get('/news/category/{category}', [NewsController::class, 'byCategory']);
Route::get('/news/{newsId}/comments', [NewsController::class, 'comments']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/search/live', [SearchController::class, 'live']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    
    Route::get('/saved', [NewsController::class, 'saved']);
    Route::post('/news/{id}/save', [NewsController::class, 'save']);
    Route::delete('/news/{id}/unsave', [NewsController::class, 'unsave']);

    
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
    Route::get('/my-comments', [CommentController::class, 'myComments']);

    
    Route::get('/history', [ProfileController::class, 'history']);
    Route::delete('/history/clear', [ProfileController::class, 'clearHistory']);

   
    Route::middleware('role:admin|helper')->group(function () {
        Route::post('/news', [NewsController::class, 'store']);
        Route::put('/news/{id}', [NewsController::class, 'update']);
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);

        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::post('/admin/users/{id}/role', [AdminController::class, 'updateRole']);

        Route::get('/admin/settings', [AdminController::class, 'settings']);
        Route::post('/admin/settings', [AdminController::class, 'updateSettings']);

        Route::get('/admin/contacts', [AdminController::class, 'contacts']);
        Route::get('/admin/contacts/{id}', [AdminController::class, 'contactShow']);
        Route::patch('/admin/contacts/{id}/status', [AdminController::class, 'updateContactStatus']);
        Route::patch('/admin/contacts/{id}/mark-read', [AdminController::class, 'markContactRead']);

        Route::get('/admin/stats', [AdminController::class, 'stats']);
    });
});