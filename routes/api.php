<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMembershipController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\api\AuthController;


// --- JAVNE API RUTE ---
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

// --- AUTENTIFICIRANE API RUTE ---
Route::middleware('auth:sanctum')->group(function () {

    // Dodatne auth rute
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // Dohvaća podatke o trenutno ulogiranom korisniku.
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- GRUPE ---
    Route::post('/groups', [GroupController::class, 'store'])->middleware('throttle:uploads')->name('api.groups.store');
    Route::post('/groups/{group}', [GroupController::class, 'update'])->middleware('throttle:uploads')->name('api.groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('api.groups.destroy');
    Route::post('/groups/{group}/membership', [GroupMembershipController::class, 'toggle'])->name('api.groups.membership');
    Route::any('/groups/search', [GroupController::class, 'search'])->name('api.groups.search');

    // --- POSTOVI ---
    Route::post('/groups/{group}/posts', [PostController::class, 'store'])->middleware('throttle:uploads')->name('api.posts.store');
    Route::delete('/groups/{group}/posts/{post}', [PostController::class, 'destroy'])->name('api.posts.destroy');

    // --- KOMENTARI ---
    Route::post('/groups/{group}/posts/{post}/comments', [CommentController::class, 'store'])->middleware('throttle:uploads')->name('api.comments.store');
    Route::delete('/groups/{group}/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('api.comments.destroy');

    // --- LAJKOVI ---
    Route::get('/posts/{post}/likes', [LikeController::class, 'indexPost'])->name('api.posts.likes.index');
    Route::post('/posts/{post}/likes', [LikeController::class, 'togglePost'])->name('api.posts.likes.toggle');
    Route::get('/comments/{comment}/likes', [LikeController::class, 'indexComment'])->name('api.comments.likes.index');
    Route::post('/comments/{comment}/likes', [LikeController::class, 'toggleComment'])->name('api.comments.likes.toggle');

    // --- NOTIFIKACIJE ---
    Route::get('/notifications', [NotificationController::class, 'index'])->name('api.notifications.index');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('api.notifications.destroyAll');
    Route::get('/notifications/count', [NotificationController::class, 'unseenCount'])->name('api.notifications.count');
    Route::post('/notifications/count', [NotificationController::class, 'markReadNotifications'])->name('api.notifications.markRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('api.notification.destroy');

    // --- DASHBOARD PODACI ---
    Route::get('/dashboard/yourGroups', [DashboardController::class, 'yourGroups'])->name('api.dashboard.yourGroups');
    Route::get('/dashboard/joinedGroups', [DashboardController::class, 'joinedGroups'])->name('api.dashboard.joinedGroups');
    Route::get('/dashboard/posts', [DashboardController::class, 'posts'])->name('api.dashboard.posts');
    Route::get('/dashboard/invitations', [DashboardController::class, 'invitations'])->name('api.dashboard.invitations');

    // --- POZIVNICE ---
    Route::get('/groups/{group}/invitations', [InvitationController::class, 'groupIndex'])->name('api.invitations.groupIndex');
    Route::post('/groups/{group}/invitations', [InvitationController::class, 'store'])->name('api.invitations.store');
    Route::delete('/groups/{group}/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('api.invitations.destroy');
    Route::post('/groups/{group}/invitations/{invitation}', [InvitationController::class, 'adminConfirm'])->name('api.invitations.adminConfirm');

    // --- POSTAVKE ---
    Route::post('/settings', [SettingsController::class, 'update'])->middleware('throttle:uploads')->name('api.settings.update');
});
