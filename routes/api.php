<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StallController;

// Route::post('/stall/login', [StallController::class, 'apiLogin']);

Route::post('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('/stallLogin', [StallController::class, 'apiLogin']);
Route::post('/stallLogout', [StallController::class, 'apiLogout']);
Route::post('/scanUser', [StallController::class, 'apiScanUser']);
Route::post('/StallUserList', [StallController::class, 'apiUserlist']);
Route::post('/stall-user-export-list', [StallController::class, 'apiUserExportList']);
