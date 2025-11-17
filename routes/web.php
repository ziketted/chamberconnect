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
    Route::get('/my-chambers', [DashboardController::class, 'myChambers'])->name('my-chambers');
    Route::get('/dashboard/load-events', [DashboardController::class, 'loadEvents'])->name('dashboard.load-events');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Super Admin Routes (is_admin = 1)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\SuperAdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/chambers', [\App\Http\Controllers\Admin\SuperAdminController::class, 'chambers'])->name('admin.chambers');
        Route::get('/admin/users', [\App\Http\Controllers\Admin\SuperAdminController::class, 'users'])->name('admin.users');

        // Gestion des chambres
        Route::get('/chambers/create', [ChamberController::class, 'create'])->name('chambers.create');
        Route::post('/chambers', [ChamberController::class, 'store'])->name('chambers.store');
        Route::patch('/admin/chambers/{chamber}/verify', [\App\Http\Controllers\Admin\SuperAdminController::class, 'verifyChamber'])->name('admin.chambers.verify');
        Route::patch('/admin/chambers/{chamber}/unverify', [\App\Http\Controllers\Admin\SuperAdminController::class, 'unverifyChamber'])->name('admin.chambers.unverify');
        Route::patch('/admin/chambers/{chamber}/suspend', [\App\Http\Controllers\Admin\SuperAdminController::class, 'suspendChamber'])->name('admin.chambers.suspend');

        // Certification des chambres avec numéro d'état (utilise slug)
        Route::post('/admin/chambers/{chamber:slug}/certify', [\App\Http\Controllers\Admin\SuperAdminController::class, 'certifyChamber'])->name('admin.chambers.certify');
        Route::patch('/admin/chambers/{chamber:slug}/uncertify', [\App\Http\Controllers\Admin\SuperAdminController::class, 'uncertifyChamber'])->name('admin.chambers.uncertify');

        // API pour autocomplétion des utilisateurs
        Route::get('/api/users/search', [\App\Http\Controllers\ChamberMemberController::class, 'searchUsers'])->name('api.users.search');

        // Gestion détaillée d'une chambre (page dédiée)
        Route::get('/admin/chambers/{chamber}/manage', [\App\Http\Controllers\Admin\SuperAdminController::class, 'manageChamber'])->name('admin.chambers.manage');
        Route::post('/admin/chambers/{chamber}/remove-member', [\App\Http\Controllers\Admin\SuperAdminController::class, 'removeMember'])->name('admin.chambers.remove-member');

        // Gestion des gestionnaires
        Route::get('/admin/chambers/{chamber}/assign-manager', [\App\Http\Controllers\Admin\SuperAdminController::class, 'showAssignManager'])->name('admin.chambers.assign-manager.show');
        Route::post('/admin/chambers/{chamber}/assign-manager', [\App\Http\Controllers\Admin\SuperAdminController::class, 'assignManager'])->name('admin.chambers.assign-manager');
        Route::delete('/admin/chambers/{chamber}/remove-manager', [\App\Http\Controllers\Admin\SuperAdminController::class, 'removeManager'])->name('admin.chambers.remove-manager');
        Route::patch('/admin/users/{user}/promote', [\App\Http\Controllers\Admin\SuperAdminController::class, 'promoteToManager'])->name('admin.users.promote');
        Route::patch('/admin/users/{user}/demote', [\App\Http\Controllers\Admin\SuperAdminController::class, 'demoteToUser'])->name('admin.users.demote');

        // Gestion des demandes de création de chambres
        Route::get('/admin/chambers/pending-requests', [\App\Http\Controllers\Admin\SuperAdminController::class, 'pendingRequests'])->name('admin.chambers.pending-requests');
        Route::post('/admin/chambers/{chamber}/approve-request', [\App\Http\Controllers\Admin\SuperAdminController::class, 'approveChamberRequest'])->name('admin.chambers.approve-request');
        Route::post('/admin/chambers/{chamber}/reject-request', [\App\Http\Controllers\Admin\SuperAdminController::class, 'rejectChamberRequest'])->name('admin.chambers.reject-request');

        // Ancienne route pour compatibilité
        Route::get('/admin/chambers/admins', [\App\Http\Controllers\Admin\ChamberAdminController::class, 'index'])->name('admin.chambers.admins');
    });
    Route::middleware('chamber.manager')->group(function () {
        // Section "Gestion des chambres" - Point d'entrée principal
        Route::get('/manage-chambers', [\App\Http\Controllers\ChamberManagerController::class, 'index'])->name('manage-chambers.index');

        // Tableau de bord gestionnaire pour une chambre spécifique
        Route::get('/chambers/{chamber}/dashboard', [\App\Http\Controllers\ChamberManagerController::class, 'dashboard'])->name('chamber-manager.dashboard');

        // Gestion des chambres
        Route::get('/chambers/{chamber}/edit', [ChamberController::class, 'edit'])->name('chambers.edit');
        Route::put('/chambers/{chamber}', [ChamberController::class, 'update'])->name('chambers.update');

        // Gestion des membres
        Route::get('/chambers/{chamber}/manage-members', [\App\Http\Controllers\ChamberManagerController::class, 'manageMembers'])->name('chambers.manage-members');
        Route::post('/chambers/{chamber}/members/{user}/approve', [\App\Http\Controllers\ChamberManagerController::class, 'approveMember'])->name('chambers.members.approve');
        Route::post('/chambers/{chamber}/members/{user}/reject', [\App\Http\Controllers\ChamberManagerController::class, 'rejectMember'])->name('chambers.members.reject');
        Route::delete('/chambers/{chamber}/members/{user}', [\App\Http\Controllers\ChamberManagerController::class, 'removeMember'])->name('chambers.members.remove');
        Route::patch('/chambers/{chamber}/members/{user}/role', [\App\Http\Controllers\ChamberManagerController::class, 'changeRole'])->name('chambers.members.change-role');

        Route::get('/chambers/{chamber}/members/create', [\App\Http\Controllers\ChamberMemberController::class, 'create'])->name('chambers.members.create');
        Route::post('/chambers/{chamber}/members', [\App\Http\Controllers\ChamberMemberController::class, 'store'])->name('chambers.members.store');
        Route::get('/chambers/{chamber}/members/pending', [\App\Http\Controllers\ChamberMemberController::class, 'pending'])->name('chambers.members.pending');
        Route::get('/chambers/{chamber}/members/{user}/details', [\App\Http\Controllers\ChamberManagerController::class, 'memberDetails'])->name('chambers.members.details');

        // Events
        Route::get('/chambers/{chamber}/events/create', [\App\Http\Controllers\ChamberEventController::class, 'create'])->name('chambers.events.create');
        Route::post('/chambers/{chamber}/events', [\App\Http\Controllers\ChamberEventController::class, 'store'])->name('chambers.events.store');
        Route::get('/chambers/{chamber}/events/{event}/participants', [\App\Http\Controllers\ChamberEventController::class, 'participants'])->name('chambers.events.participants');
        Route::patch('/chambers/{chamber}/events/{event}/participants/{user}', [\App\Http\Controllers\ChamberEventController::class, 'updateParticipantStatus'])->name('chambers.events.participants.update');
        // Partners
        Route::get('/chambers/{chamber}/partners/create', [\App\Http\Controllers\ChamberPartnerController::class, 'create'])->name('chambers.partners.create');
        Route::post('/chambers/{chamber}/partners', [\App\Http\Controllers\ChamberPartnerController::class, 'store'])->name('chambers.partners.store');
        // Posts
        Route::get('/chambers/{chamber}/posts/create', [\App\Http\Controllers\ChamberPostController::class, 'create'])->name('chambers.posts.create');
        Route::post('/chambers/{chamber}/posts', [\App\Http\Controllers\ChamberPostController::class, 'store'])->name('chambers.posts.store');
        // Forums
        Route::get('/chambers/{chamber}/forums/create', [\App\Http\Controllers\ChamberForumController::class, 'create'])->name('chambers.forums.create');
        Route::post('/chambers/{chamber}/forums', [\App\Http\Controllers\ChamberForumController::class, 'store'])->name('chambers.forums.store');
    });

    // Membership approval (manager)
    Route::post('/chambers/{chamber}/members/{user}/approve', [\App\Http\Controllers\ChamberMemberController::class, 'approve'])->middleware('chamber.manager')->name('chambers.members.approve');
});

// Membership join (auth only, not requiring email verification)
Route::middleware('auth')->group(function () {
    Route::post('/chambers/{chamber}/join', [\App\Http\Controllers\ChamberMemberController::class, 'join'])->name('chambers.members.join');

    // Event booking routes
    Route::post('/events/{event}/book', [\App\Http\Controllers\EventBookingController::class, 'book'])->name('events.book');
    Route::delete('/events/{event}/cancel', [\App\Http\Controllers\EventBookingController::class, 'cancel'])->name('events.cancel');
    Route::patch('/events/{event}/confirm', [\App\Http\Controllers\EventBookingController::class, 'confirm'])->name('events.confirm');
    Route::get('/my-bookings', [\App\Http\Controllers\EventBookingController::class, 'myBookings'])->name('events.my-bookings');

    // API route for event details
    Route::get('/api/events/{event}/details', [\App\Http\Controllers\EventController::class, 'getEventDetails'])->name('api.events.details');

    // Settings routes
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/theme', [\App\Http\Controllers\SettingsController::class, 'updateTheme'])->name('settings.theme');
    Route::post('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile');

    // Event likes routes
    Route::post('/events/{event}/like', [\App\Http\Controllers\EventLikeController::class, 'toggle'])->name('events.like');

    // Portal routes (for regular users only)
    Route::middleware('verified')->group(function () {
        Route::get('/portal', [\App\Http\Controllers\ChamberPortalController::class, 'index'])->name('portal.index');
        Route::get('/portal/chamber/create', [\App\Http\Controllers\ChamberPortalController::class, 'create'])->name('portal.chamber.create');
        Route::post('/portal/chamber/store', [\App\Http\Controllers\ChamberPortalController::class, 'store'])->name('portal.chamber.store');
        Route::get('/portal/chamber/success', [\App\Http\Controllers\ChamberPortalController::class, 'success'])->name('portal.chamber.success');
        Route::get('/portal/chamber/my-requests', [\App\Http\Controllers\ChamberPortalController::class, 'myRequests'])->name('portal.chamber.my-requests');
    });
});

// Socialite Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// Route de test temporaire
Route::get('/test-user-role', function () {
    if (!auth()->check()) {
        return 'Utilisateur non connecté';
    }

    $user = auth()->user();
    return [
        'name' => $user->name,
        'email' => $user->email,
        'is_admin' => $user->is_admin,
        'isSuperAdmin' => $user->isSuperAdmin(),
        'isChamberManager' => $user->isChamberManager(),
        'isRegularUser' => $user->isRegularUser(),
    ];
})->middleware('auth');

// Route de test pour vérifier le rôle utilisateur
Route::get('/test-user-role-debug', function () {
    if (!auth()->check()) {
        return 'Utilisateur non connecté';
    }

    $user = auth()->user();
    return [
        'name' => $user->name,
        'email' => $user->email,
        'is_admin' => $user->is_admin,
        'is_admin_type' => gettype($user->is_admin),
        'is_admin_raw' => var_export($user->is_admin, true),
        'condition_result' => ($user->is_admin === 0 || $user->is_admin === null),
        'condition_details' => [
            'is_admin_equals_0' => $user->is_admin === 0,
            'is_admin_equals_null' => $user->is_admin === null,
        ],
        'isRegularUser' => $user->isRegularUser(),
        'isSuperAdmin' => $user->isSuperAdmin(),
        'isChamberManager' => $user->isChamberManager(),
    ];
})->middleware('auth');

// Route de test pour les fonctionnalités super admin
Route::get('/test-super-admin-features', function () {
    if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
        return 'Accès refusé - Super Admin requis';
    }

    $chambers = \App\Models\Chamber::with(['members' => function ($query) {
        $query->wherePivot('role', 'manager');
    }])->get();

    $stats = [
        'total_chambers' => \App\Models\Chamber::count(),
        'verified_chambers' => \App\Models\Chamber::where('verified', true)->count(),
        'pending_chambers' => \App\Models\Chamber::where('verified', false)->count(),
        'certified_chambers' => \App\Models\Chamber::whereNotNull('state_number')->count(),
        'total_users' => \App\Models\User::count(),
        'chamber_managers' => \App\Models\User::where('is_admin', \App\Models\User::ROLE_CHAMBER_MANAGER)->count(),
        'regular_users' => \App\Models\User::where('is_admin', \App\Models\User::ROLE_USER)->count(),
    ];

    return [
        'message' => 'Fonctionnalités Super Admin disponibles',
        'stats' => $stats,
        'chambers_sample' => $chambers->take(3)->map(function ($chamber) {
            return [
                'id' => $chamber->id,
                'name' => $chamber->name,
                'verified' => $chamber->verified,
                'state_number' => $chamber->state_number,
                'certification_date' => $chamber->certification_date,
                'managers_count' => $chamber->members->where('pivot.role', 'manager')->count(),
                'total_members' => $chamber->members->count(),
            ];
        }),
    ];
})->middleware('auth');

// Include Breeze Authentication Routes
require __DIR__ . '/auth.php';
