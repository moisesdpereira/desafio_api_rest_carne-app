<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarneController;

Route::post('/carne', [CarneController::class, 'store']);
Route::get('/carne/{id}/parcelas', [CarneController::class, 'getParcelas']);
