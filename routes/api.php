<?php

use App\Http\Controllers\Api\V1\ComboItemController;
use App\Http\Controllers\Api\V1\UuidItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('combo-items', ComboItemController::class);
    Route::get('combo-items/by-id/{combo_item:id}', [ComboItemController::class, 'show']);
    Route::apiResource('uuid-items', UuidItemController::class);
});
