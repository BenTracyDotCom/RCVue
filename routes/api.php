<?php

use App\Http\Controllers\PartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Part;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/parts', [PartController::class,'getAvailableParts'])->name('api.getAvailableParts');

Route::post('/parts', [PartController::class,'store'])->name('api.storePart');