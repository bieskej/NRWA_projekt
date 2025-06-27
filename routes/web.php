<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ovdje se registriraju rute za tvoju WEB aplikaciju. Ove rute imaju
| session state, CSRF zaštitu, itd. i generalno vraćaju view-ove, a ne JSON.
| One NE SMIJU imati /api/ prefiks.
|
*/

// --- Rute za Login, Register, Password Reset, itd. ---
// Auth::routes() mora biti OVDJE, izvan bilo kakvih grupa s prefiksom.
Auth::routes();


// --- RUTE KOJE PRIKAZUJU STRANICE ---

// Javne rute koje svatko može vidjeti
Route::get('/', [DashboardController::class, 'feed'])->name('dashboard.feed');
Route::get('/popular', [DashboardController::class, 'popular'])->name('dashboard.popular');

// Rute za prikazivanje sadržaja koje mogu zahtijevati 'can:view' provjeru
Route::middleware('can:view,group')->group(function () {
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/{group}/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/groups/{group}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/groups/{group}/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
});


// --- RUTE KOJE ZAHTJEVAJU DA KORISNIK BUDE ULOGIRAN ---
Route::middleware('auth')->group(function () {
    // Stranica za prikaz korisničkih postavki
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');

    // Stranica za kreiranje nove grupe
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
});


// --- SOCIALITE RUTE (Login s GitHubom) ---
Route::get('/auth/github/redirect', [SocialiteController::class, 'redirect'])->name('github.redirect');
Route::get('/auth/github/callback', [SocialiteController::class, 'callback'])->name('github.callback');
