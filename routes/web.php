<?php

use App\Http\Controllers\OpenRouteController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureTokenIsValid;

Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->middleware('auth');

Route::get('/reject', function () {
    return view('unable');
})->name('rejected');

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/', function () {
        return view('main.main');
    })->name('home');
    Route::get('/gallery', function () {
        return view('galeries');
    })->name('gallery');
    Route::get('/about', function () {
        return view('AboutUs');
    })->name('about');
    Route::get('/news', function () {
        return view('main.news');
    })->name('news');
    Route::get('/read/{hash}/{id}', function ($hash, $id) {
        $key = intval($id);
        return view('main.news-content', compact('key'));
    })->name('news-content');
    Route::get('/announcements', function () {
        return view('main.announcement');
    })->name('announcements');
    Route::get('/events', function () {
        return view('main.events');
    })->name('events');
    Route::get('/announcements-comment/{id}', function ($id) {
        Session::put('comment', $id);
        return redirect('/announcements#' . $id)->with('comment', $id);
    })->name('comment_section');

    Route::view('/home', 'main.announcement')
        ->name('dashboard');


    Route::get('/otp', [OTPController::class, 'sentOtp'])->name('otp');

    
    Route::view('/otpMail', 'otpMail');
    Route::view('/CreatePassword', 'CreatePassword');
    
});


Route::get('/verify/otp/{code}', [OTPController::class, 'verifyOtp']);  
Route::get('/SendNewEmailsContinuesly', [OTPController::class, 'SendNewEmailsContinuesly']); //cron jobs
Route::get('/create-new-password/token/{token}/email/{email}', [OTPController::class, 'createNewPassword']);
Route::get('/verify/{password}', [OTPController::class, 'verifyPassword']);
Route::post('/ask', [OpenRouteController::class, 'ask']);

require __DIR__ . '/auth.php';
require __DIR__ . '/parent/web.php';
require __DIR__ . '/firebase/web.php';
require __DIR__ . '/app/api.php';
 