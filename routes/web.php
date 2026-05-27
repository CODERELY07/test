<?php

use App\Http\Controllers\RepairController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/repairs', [RepairController::class, 'index']);
