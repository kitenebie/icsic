<?php

use App\Http\Controllers\OpenRouteController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\NotificationController;

Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->middleware('auth');

Route::get('/reject', function () {
    return view('unable');
})->name('rejected');
Route::get('/', function () {
    return view('main.main');
})->name('home')
    ->middleware(['auth', 'verified']);
Route::get('/gallery', function () {
    return view('galeries');
})->name('gallery')
    ->middleware(['auth', 'verified']);
Route::get('/about', function () {
    return view('AboutUs');
})->name('about')
    ->middleware(['auth', 'verified']);
Route::get('/news', function () {
    return view('main.news');
})->name('news')
    ->middleware(['auth', 'verified']);
Route::get('/read/{hash}/{id}', function ($hash, $id) {
    $key = intval($id);
    return view('main.news-content', compact('key'));
})->name('news-content')
    ->middleware(['auth', 'verified']);
Route::get('/announcements', function () {
    return view('main.announcement');
})->name('announcements')
    ->middleware(['auth', 'verified']);
Route::get('/events', function () {
    return view('main.events');
})->name('events')
    ->middleware(['auth', 'verified']);
Route::get('/announcements-comment/{id}', function ($id) {
    Session::put('comment', $id);
    return redirect('/announcements#' . $id)->with('comment', $id);
})->name('comment_section')
    ->middleware(['auth', 'verified']);

Route::view('NewsPage', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::post('/ask', [OpenRouteController::class, 'ask']);

require __DIR__ . '/auth.php';
require __DIR__ . '/parent/web.php';
require __DIR__ . '/firebase/web.php';
