<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');


Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google-auth');
Route::get('auth/callback', [GoogleController::class, 'authCallBack']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    Route::get('website', [WebsiteController::class, 'index'])->name('website');
    
    Route::get('table', function () {
        return Inertia::render('websitetbl/page');
    })->name('table');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
