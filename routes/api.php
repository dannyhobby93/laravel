<?php

use App\Http\Controllers\ComboTableController;
use App\Http\Controllers\UuidOnlyController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return 'Hello world';
});

Route::apiResource('combo-table', ComboTableController::class);
Route::apiResource('uuid-only', UuidOnlyController::class);
