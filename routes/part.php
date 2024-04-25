<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('parts')->group(function () {

  Route::get('/', function() {
    return Inertia::render('Parts');
  });
  
  Route::get('/create', function() {
    return Inertia::render('AddPart');
  });

});