<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return ['Laravel' => app()->version()];
//});
//
//Route::resource('news', NewsController::class);

Route::get('/news', [NewsController::class, 'index']);

Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login');
    // Other routes...
});


//require __DIR__.'/auth.php';
