<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::get('website', function () {
        return Inertia::render('website');
    })->name('website');
    
    Route::get('table', function () {
        return Inertia::render('websitetbl/page');
    })->name('table');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
