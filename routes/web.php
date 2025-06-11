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
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

    // مسیر برای پردازش فرم ویرایش پروفایل
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');


    // Expertise routes
    Route::get('/expertise', [ExpertiseController::class, 'create'])->name('user.expertise'); // show form
    // Route::get('/expertise/create', [ExpertiseController::class, 'create'])->name('user.expertise.create');
    Route::post('/expertise/store', [ExpertiseController::class, 'store'])->name('user.expertise.store');
    Route::get('/expertise/show', [ExpertiseController::class, 'show'])->name('user.expertise.show');
    Route::get('/expertise/showAll', [ExpertiseController::class, 'showAll'])->name('expertises.show');

    // در فایل web.php
    Route::get('/expertise/{expertise}', [ExpertiseController::class, 'showDetails'])->name('user.expertise.details');


    Route::get('/expertises/{expertise}/edit', [ExpertiseController::class, 'edit'])->name('user.expertise.edit');
    Route::put('/expertises/{expertise}', [ExpertiseController::class, 'update'])->name('user.expertise.update');
    Route::delete('/expertises/{expertise}', [ExpertiseController::class, 'destroy'])->name('user.expertise.destroy');

});
