<?php

use App\Http\Controllers\blog\BlogController;
use App\Http\Controllers\ProfileController;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $blogs = Blog::latest()->get();
    $populars = Blog::where('type', 'popular')->latest();
    return view('welcome', compact('blogs', 'populars'));
})->name('blog.home');

Route::get('/dashboard', function () {
    $blogs = Blog::where('userID', Auth::user()->userID)->latest()->paginate(9);
    $allblogs = Blog::latest()->paginate(9);
    return view('dashboard', compact('blogs', 'allblogs'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/change-profile/{uid}', [ProfileController::class, 'change_profile']);
    Route::delete('/profile/image/remove/{uid}', [ProfileController::class, 'remove_profile']);

    // ? Blog routes
    Route::post('/add-blog', [BlogController::class, 'addBlog'])->name('blog.add');
    Route::put('/blog/update/{token}', [BlogController::class, 'update']);
    Route::get('/blog/full/{token}', [BlogController::class, 'read_more']);
    Route::delete('/blog/delete/{uid}', [BlogController::class, 'destroy']);
});

require __DIR__ . '/auth.php';
