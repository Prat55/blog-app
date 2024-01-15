<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\blog\BlogController;
use App\Http\Controllers\blog\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFA\TwoFA_Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    $users = User::latest()->paginate(9);

    return view('dashboard', compact('users', 'blogs', 'allblogs'));
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/change-profile/{uid}', [ProfileController::class, 'change_profile']);
    Route::delete('/profile/image/remove/{uid}', [ProfileController::class, 'remove_profile']);

    // ? Blog & comment routes
    Route::post('/add-blog', [BlogController::class, 'addBlog'])->name('blog.add');
    Route::put('/blog/update/{token}', [BlogController::class, 'update']);
    Route::get('/blog/full/{token}', [BlogController::class, 'read_more']);
    Route::delete('/blog/delete/{uid}', [BlogController::class, 'destroy']);
    Route::post('/blog/comment', [CommentController::class, 'comment']);
    Route::post('/comment/remove/{uid}', [CommentController::class, 'remove']);

    // ? Two Factor Authentication routes
    Route::post('/2FA/enable/request', [TwoFA_Controller::class, 'enable_request'])->name('enable.2fa');
    Route::post('/2FA/disable/request', [TwoFA_Controller::class, 'disable_request'])->name('disable.2fa');
    Route::get('/2FA/verify', [TwoFA_Controller::class, 'verification'])->name('verification');
    Route::post('/2FA/verifying', [TwoFA_Controller::class, 'verify_otp'])->name('verifying.otp');

    // ? User Two Factor Authentication
    Route::get('/verify', [TwoFA_Controller::class, 'login_verification'])->name('login_verification');
    Route::post('/verified', [TwoFA_Controller::class, 'login_verification_user'])->name('login.verified');
});

Route::middleware('admin')->group(function () {
    Route::post('/user/ban/{token}', [UserController::class, 'ban']);
    Route::post('/user/unban/{token}', [UserController::class, 'unban']);
});

require __DIR__ . '/auth.php';
