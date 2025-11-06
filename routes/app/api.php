<?php
use App\Http\Controllers\SmsAPIController;
use App\Http\Controllers\CurrentDateController;
use Illuminate\Support\Facades\Route;

Route::get('/api/sms/', [SmsAPIController::class, 'getDATA']);
Route::get('/api/sms/{id}/update/{status}', [SmsAPIController::class, 'update']);
Route::get('/current/datethe', [CurrentDateController::class, 'getCurrentDate']);