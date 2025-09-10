<?php

use App\Http\Controllers\OpenRouteController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureTokenIsValid;
use GuzzleHttp\Client;

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


Route::get('/scrape-hrefs', function () {
    $client = new Client();

    // Fetch the page
    $response = $client->get('https://openrouter.ai/models/?fmt=cards&input_modalities=text&max_price=0&q=free&output_modalities=text');
    $html = $response->getBody()->getContents();

    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $hrefs = [];
    $nodes = $xpath->query('//a[@class="transition-colors text-secondary-foreground hover:text-foreground hover:underline underline-offset-2 text-base font-medium md:text-xl"]/@href');

    foreach ($nodes as $href) {
        $hrefs[] = $href->nodeValue;
    }

    // Example: filter only those that match /qwen/*
    $qwenLinks = array_filter($hrefs, function ($href) {
        return str_contains($href, ':free');
    });

    return array_values($hrefs);
});