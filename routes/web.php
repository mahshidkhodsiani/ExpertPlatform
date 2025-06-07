<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LinkedInController;
use App\Http\Controllers\Auth\AppleController;
use App\Http\Controllers\ExpertiseController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Google Auth Routes
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// LinkedIn Auth Routes
Route::get('/auth/linkedin', [LinkedInController::class, 'redirect'])->name('auth.linkedin');
Route::get('/auth/linkedin/callback', [LinkedInController::class, 'callback']);

// Apple Auth Routes
Route::get('/auth/apple', [AppleController::class, 'redirect'])->name('auth.apple');
Route::get('/auth/apple/callback', [AppleController::class, 'callback']);




Route::middleware(['auth'])->group(function () {
    // Common dashboard that redirects based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'expert') {
            return redirect()->route('expert.dashboard');
        }

        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Specific dashboards
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/expert/dashboard', [ExpertController::class, 'index'])->name('expert.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Expertise routes
    Route::get('/expertise', [ExpertiseController::class, 'create'])->name('user.expertise'); // show form
    Route::post('/expertise', [ExpertiseController::class, 'store'])->name('user.expertise.store'); // store expertise
});
