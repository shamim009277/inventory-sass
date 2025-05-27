<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionPlanController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard1');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('subscription-plans', SubscriptionPlanController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
