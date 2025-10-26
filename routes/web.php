<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('posts/lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
})->name('lang');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->name('profile.index');

    Route::post('topics/create', [TopicController::class, 'store'])->name('topics.store')->can('create', Topic::class);
    Route::get('topics/create', [TopicController::class, 'create'])->name('topics.create')->can('create', Topic::class);

    // Route::resource('posts', PostController::class)->only(['create', 'store']);
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create')
        ->can('create', Post::class);
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->can('delete', Post::class);

    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')
        ->can('delete', 'comment');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update')
        ->can('update', 'comment');

    Route::post('likes/{type}/{id}', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('likes/{type}/{id}', [LikeController::class, 'destroy'])->name('likes.destroy');

});

Route::get('post/{post}/{slug?}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{topic?}', [PostController::class, 'index'])->name('posts.index');
