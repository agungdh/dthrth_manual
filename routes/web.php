<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DTHRTHController;
use App\Http\Controllers\SkpdController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::post('/dthrth/datatableLihat', [DTHRTHController::class, 'datatableLihat']);
Route::post('/dthrth/datatable', [DTHRTHController::class, 'datatable']);
Route::post('/dthrth/listDuped', [DTHRTHController::class, 'listDuped']);
Route::post('/dthrth/checkDuplikat', [DTHRTHController::class, 'checkDuplikat']);
Route::post('/dthrth/check', [DTHRTHController::class, 'check']);
Route::resource('/dthrth', DTHRTHController::class);

Route::post('/skpd/datatable', [SkpdController::class, 'datatable']);
Route::resource('/skpd', SkpdController::class);

require __DIR__.'/auth.php';
