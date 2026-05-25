<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\CleaningLogController;
use App\Http\Controllers\Api\DeliveryTruckLogController;
use App\Http\Controllers\Api\OilTemperatureLogController;
use App\Http\Controllers\Api\PestControlLogController;
use App\Http\Controllers\Api\RawMaterialLogController;
use App\Http\Controllers\Api\StockManagementLogController;
use Illuminate\Support\Facades\Route;

Route::get('/analytics', [AnalyticsController::class, 'index']);

Route::apiResource('raw-material-logs', RawMaterialLogController::class);
Route::apiResource('delivery-truck-logs', DeliveryTruckLogController::class);
Route::apiResource('pest-control-logs', PestControlLogController::class);
Route::apiResource('oil-temperature-logs', OilTemperatureLogController::class);
Route::apiResource('cleaning-logs', CleaningLogController::class);
Route::apiResource('stock-management-logs', StockManagementLogController::class);
