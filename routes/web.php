<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update'); 

    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
    Route::post('/feed/{id}/like', [FeedController::class, 'like'])->name('feed.like');
    Route::post('/feed/{id}/dislike', [FeedController::class, 'dislike'])->name('feed.dislike');

    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/results', [SearchController::class, 'results'])->name('search.results');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    Route::get('/tags', [AdminController::class, 'tags'])->name('admin.tags');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
});