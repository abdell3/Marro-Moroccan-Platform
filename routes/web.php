<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    
});


Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
 
});


Route::middleware(['auth', 'role:Moderateur'])->prefix('moderator')->name('moderator.')->group(function () {
    Route::get('/dashboard', function () {
        return view('moderator.dashboard');
    })->name('dashboard');
    
    
});