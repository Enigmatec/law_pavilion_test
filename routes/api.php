<?php

use App\Http\Controllers\ExportConsolidatedOrderController;
use App\Http\Controllers\ImportConsolidatedOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('export', ExportConsolidatedOrderController::class);
Route::post('import', ImportConsolidatedOrderController::class);