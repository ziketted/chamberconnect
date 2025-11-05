<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChamberListController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OpportunityController;
use Illuminate\Support\Facades\Route;

// Language Switcher
Route::get('language/{locale}', [LanguageController::class, 'switch'])
    ->name('language.switch')
    ->where('locale', 'en|fr');

// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Chambers Routes
Route::get('/chambers', [ChamberListController::class, 'index'])->name('chambers');
Route::get('/chamber/{chamber}', [ChamberController::class, 'show'])->name('chamber.show');

// Events Routes
Route::get('/events', [EventController::class, 'index'])->name('events');

// Opportunities Routes
Route::get('/opportunities', [OpportunityController::class, 'index'])->name('opportunities');

// Auth Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chamber create & manage
    Route::middleware('admin')->group(function () {
        Route::get('/chambers/create', [ChamberController::class, 'create'])->name('chambers.create');
        Route::post('/chambers', [ChamberController::class, 'store'])->name('chambers.store');
        Route::get('/admin/chambers/admins', [\App\Http\Controllers\Admin\ChamberAdminController::class, 'index'])->name('admin.chambers.admins');
    });
    Route::middleware('chamber.manager')->group(function () {
        Route::get('/chambers/{chamber}/edit', [ChamberController::class, 'edit'])->name('chambers.edit');
        Route::put('/chambers/{chamber}', [ChamberController::class, 'update'])->name('chambers.update');
        // Events
        Route::get('/chambers/{chamber}/events/create', [\App\Http\Controllers\ChamberEventController::class, 'create'])->name('chambers.events.create');
        Route::post('/chambers/{chamber}/events', [\App\Http\Controllers\ChamberEventController::class, 'store'])->name('chambers.events.store');
        // Partners
        Route::get('/chambers/{chamber}/partners/create', [\App\Http\Controllers\ChamberPartnerController::class, 'create'])->name('chambers.partners.create');
        Route::post('/chambers/{chamber}/partners', [\App\Http\Controllers\ChamberPartnerController::class, 'store'])->name('chambers.partners.store');
        // Posts
        Route::get('/chambers/{chamber}/posts/create', [\App\Http\Controllers\ChamberPostController::class, 'create'])->name('chambers.posts.create');
        Route::post('/chambers/{chamber}/posts', [\App\Http\Controllers\ChamberPostController::class, 'store'])->name('chambers.posts.store');
        // Forums
        Route::get('/chambers/{chamber}/forums/create', [\App\Http\Controllers\ChamberForumController::class, 'create'])->name('chambers.forums.create');
        Route::post('/chambers/{chamber}/forums', [\App\Http\Controllers\ChamberForumController::class, 'store'])->name('chambers.forums.store');
        // Members
        Route::get('/chambers/{chamber}/members/create', [\App\Http\Controllers\ChamberMemberController::class, 'create'])->name('chambers.members.create');
        Route::post('/chambers/{chamber}/members', [\App\Http\Controllers\ChamberMemberController::class, 'store'])->name('chambers.members.store');
        Route::get('/chambers/{chamber}/members/pending', [\App\Http\Controllers\ChamberMemberController::class, 'pending'])->name('chambers.members.pending');
    });

    // Membership approval (manager)
    Route::post('/chambers/{chamber}/members/{user}/approve', [\App\Http\Controllers\ChamberMemberController::class, 'approve'])->middleware('chamber.manager')->name('chambers.members.approve');
});

// Membership join (auth only, not requiring email verification)
Route::middleware('auth')->group(function () {
    Route::post('/chambers/{chamber}/join', [\App\Http\Controllers\ChamberMemberController::class, 'join'])->name('chambers.members.join');
});

// Socialite Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// Test route for translations (temporary)
Route::get('/test-translations', [\App\Http\Controllers\TestController::class, 'testTranslations']);

// Include Breeze Authentication Routes
require __DIR__ . '/auth.php';
