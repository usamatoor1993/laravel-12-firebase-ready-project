<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\ExampleController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/firebase', [ExampleController::class, 'index'])->name('firebase.index');
Route::post('/firebase', [ExampleController::class, 'store'])->name('firebase.store');
Route::get('/firebase/{id}', [ExampleController::class, 'show'])->name('firebase.show');
Route::put('/firebase/{id}', [ExampleController::class, 'update'])->name('firebase.update');
Route::delete('/firebase/{id}', [ExampleController::class, 'destroy'])->name('firebase.destroy');

