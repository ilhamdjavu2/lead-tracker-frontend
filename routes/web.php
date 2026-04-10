<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

Route::get('/', [LeadController::class, 'index']);
Route::prefix('leads')->group(function () {
    Route::get('/index', [LeadController::class, 'index']);
    Route::post('/', [LeadController::class, 'store']);
    Route::patch('/{id}', [LeadController::class, 'update']);
    Route::get('/datatable', [LeadController::class, 'loaddtleads']);
    Route::get('/form', [LeadController::class, 'leadform']);
    Route::delete('/delete/{id}', [LeadController::class, 'delete']);
});