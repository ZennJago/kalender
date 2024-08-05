<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index']);
Route::post('/manage-event', [EventController::class, 'manageEvent']);
Route::get('/search', [EventController::class, 'search']);  // New route for search page