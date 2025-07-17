<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Parent\selectStudentController;

Route::post("/submitSelectedStudent", [selectStudentController::class, 'selectStudentController'])->name("selectStudentController");
Route::post("/selectedRequestForm", [selectStudentController::class, 'selectedRequestForm'])->name("selectedRequestForm");
// 