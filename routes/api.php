<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies/{id}', [CompanyController::class, 'show']);
Route::get('/companies/{id}/users', [CompanyController::class, 'users']);
Route::get('/companies/{id}/bills', [CompanyController::class, 'bills']);
Route::get('/companies/{id}/report', [CompanyController::class, 'report']);
