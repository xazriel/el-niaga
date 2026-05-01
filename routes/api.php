<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JneController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('jne')->group(function () {
    Route::post('/price',        [JneController::class, 'checkPrice']);
    Route::post('/generate-awb', [JneController::class, 'generateAWB']);
    Route::get('/track/{awb}',   [JneController::class, 'track']);
});