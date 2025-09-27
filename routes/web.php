<?php

use App\Http\Controllers\OpenRouteController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Http;

Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->middleware('auth');

Route::get('/reject', function () {
    return view('unable');
})->name('rejected');
// waiting
Route::post('/forgot-password', [OTPController::class, 'sendPasswordResetLink'])
    ->name('password.email');
Route::get('/waiting', function () {
    return view('template.pendding');
})->name('waiting');

Route::view('/faq', 'faq')->name('faq');
Route::view('/view-faq', 'faq')->name('view-faq');

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

    Route::view('/home', 'main.main')
        ->name('dashboard');


    Route::get('/otp', [OTPController::class, 'sentOtp'])->name('otp');


    Route::view('/otpMail', 'otpMail');
    Route::view('/CreatePassword', 'CreatePassword');
require __DIR__ . '/auth.php';
require __DIR__ . '/parent/web.php';
require __DIR__ . '/firebase/web.php';
});


Route::get('/verify/otp/{code}', [OTPController::class, 'verifyOtp']);
Route::get('/SendNewEmailsContinuesly', [OTPController::class, 'SendNewEmailsContinuesly']); //cron jobs
Route::get('/create-new-password/token/{token}/email/{email}', [OTPController::class, 'createNewPassword']);
Route::get('/verify/{password}', [OTPController::class, 'verifyPassword']);
Route::post('/ask', [OpenRouteController::class, 'ask']);
Route::get('/fonts/instrument-sans.css', function () {
    $css = file_get_contents('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');
    return response($css)
        ->header('Content-Type', 'text/css')
        ->header('Cross-Origin-Resource-Policy', 'same-origin'); // makes COEP happy
});


require __DIR__ . '/app/api.php';



Route::get('/free-models', function () {
    $response = Http::get('https://openrouter.ai/api/v1/models');

    if ($response->failed()) {
        return response()->json(['error' => 'Failed to fetch models'], 500);
    }

    $models = $response->json('data', []);

    // filter models with all pricing set to "0"
    $freeModels = array_filter($models, function ($model) {
        if (!isset($model['pricing'])) {
            return false;
        }
        $pricing = $model['pricing'];
        return ($pricing['prompt'] === '0'
            && $pricing['completion'] === '0'
            && ($pricing['request'] ?? '0') === '0');
    });

    // build ['id' => 'id'] style array
    $result = [];
    foreach ($freeModels as $model) {
        $result[$model['id']] = $model['id'];
    }

    return $result;
});

Route::get('/delete-students-user', function () {
    $availableStudents = App\Models\Student::pluck('email'); 
    return App\Models\User::where('role', 'student')
        ->whereNotIn('email', $availableStudents)
        ->delete();
});
