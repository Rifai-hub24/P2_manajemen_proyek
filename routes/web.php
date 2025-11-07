<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\DevNotifController;

// AUTH
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// PROTECTED ROUTES
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');

    // ADMIN
    Route::middleware('role:admin')->group(function () {

        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
        Route::get('/users/active', [UserController::class, 'indexActive'])->name('users.active');
        Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::post('/projects/{project}/members', [ProjectMemberController::class, 'addMember'])->name('projects.members.add');
        // Update user anggota
        Route::put('/projects/members/{member}/update-user', [ProjectMemberController::class, 'updateUser'])->name('projects.members.updateUser');

        // Hapus anggota
        Route::delete('/projects/members/{member}/delete', [ProjectMemberController::class, 'deleteMember'])->name('projects.members.delete');
      
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');


        Route::post('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
        Route::post('/projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');
        
        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('/monitoring/{project}', [MonitoringController::class, 'show'])->name('monitoring.show');
        Route::get('/monitoring/{project}/board/{board}', [MonitoringController::class, 'board'])->name('monitoring.board');
        Route::get('/monitoring/{project}/card/{card}', [MonitoringController::class, 'card'])->name('monitoring.card');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::get('/projects/{project}/report', [ReportController::class, 'projectReport'])->name('projects.report');
        Route::get('/admin/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications');
        Route::post('/admin/notifications/dismiss', [AdminNotificationController::class, 'dismiss'])->name('admin.notifications.dismiss');
        Route::get('/admin/notifications/count', [AdminNotificationController::class, 'count'])->name('admin.notifications.count');



    });

   // Team Lead
Route::middleware(['auth','role:team_lead'])->group(function () {
    Route::get('/teamlead/dashboard', [ProjectController::class,'teamLeadDashboard'])->name('teamlead.dashboard');
    Route::get('/teamlead/projects/{project}', [ProjectController::class,'teamLeadShow'])->name('teamlead.projects.show');

    
    // Cards management
    Route::get('/teamlead/boards/{board}/cards', [CardController::class, 'index'])
        ->name('teamlead.cards.index');
    Route::get('/teamlead/boards/{board}/cards/create', [CardController::class, 'create'])
        ->name('teamlead.cards.create');
    Route::post('/teamlead/boards/{board}/cards', [CardController::class, 'store'])
        ->name('teamlead.cards.store');

    // Edit & Update
    Route::get('/teamlead/boards/{board}/cards/{card}/edit', [CardController::class, 'edit'])
        ->name('teamlead.cards.edit');
    Route::put('/teamlead/boards/{board}/cards/{card}', [CardController::class, 'update'])
        ->name('teamlead.cards.update');

    // Delete
    Route::delete('/teamlead/boards/{board}/cards/{card}', [CardController::class, 'destroy'])
        ->name('teamlead.cards.destroy');

    Route::post('/subtasks/{subtask}/approve', [SubtaskController::class, 'approve'])->name('subtasks.approve');
    Route::post('/subtasks/{subtask}/reject', [SubtaskController::class, 'reject'])
    ->name('subtasks.reject');
    
    Route::get('/solve-blocker', [SubtaskController::class, 'solveBlocker'])->name('subtasks.solveBlocker');
    Route::post('/subtasks/{subtask}/solve-blocker', [SubtaskController::class, 'solveBlockerAction'])->name('subtasks.solveBlockerAction');

    Route::get('/teamlead/boards/{board}/cards/{card}', [CardController::class, 'show'])
    ->name('teamlead.cards.show');
   Route::post('/projects/{project}/submit', [ProjectController::class, 'submit'])->name('projects.submit');
   Route::get('/teamlead/myteam', [ProjectMemberController::class, 'myTeam'])
        ->name('teamlead.myteam');
   Route::get('/teamlead/notifications', [NotificationController::class, 'index'])->name('teamlead.notifications');
   Route::post('/teamlead/notifications/dismiss', [NotificationController::class, 'dismiss'])->name('teamlead.notifications.dismiss');
   Route::get('/teamlead/notifications/count', [NotificationController::class, 'count'])->name('teamlead.notifications.count');


});
   /*
|--------------------------------------------------------------------------
| DEVELOPER & DESIGNER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:developer,designer'])->group(function() {
    // Dashboard
    Route::get('/developer/dashboard', [ProjectController::class, 'developerDashboard'])->name('developer.dashboard');
    Route::get('/designer/dashboard', [ProjectController::class, 'designerDashboard'])->name('designer.dashboard');

     // Halaman buat subtask (create)
    Route::get('/cards/{card}/subtasks/create', [SubtaskController::class, 'create'])->name('subtasks.create');

    // Simpan subtask
    Route::post('/cards/{card}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
    Route::get('/subtasks/{subtask}/edit', [SubtaskController::class, 'edit'])->name('subtasks.edit');
    Route::put('/subtasks/{subtask}', [SubtaskController::class, 'update'])->name('subtasks.update')->middleware('auth');
    Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');

    // Aksi start & complete
    Route::post('/subtasks/{subtask}/start', [SubtaskController::class, 'start'])->name('subtasks.start');
    Route::post('/subtasks/{subtask}/complete', [SubtaskController::class, 'complete'])->name('subtasks.complete');
    Route::post('/subtasks/{subtask}/block', [SubtaskController::class, 'block'])->name('subtasks.block');

    // Developer melihat tim yang satu project
    Route::get('/developer/myteam', [ProjectMemberController::class, 'developerTeam'])->name('developer.myteam');
    Route::get('/designer/myteam', [ProjectMemberController::class, 'designerTeam'])->name('designer.myteam');
    Route::get('/notifications/subtasks', [DevNotifController::class, 'index'])->name('dev.notifications');
    Route::post('/notifications/dismiss', [DevNotifController::class, 'dismiss'])->name('dev.notifications.dismiss');
    Route::get('/notifications/count', [DevNotifController::class, 'count'])->name('dev.notifications.count');
});
// Komentar
Route::middleware('auth')->group(function () {

   // 🔹 Komentar untuk Card (hanya admin & team lead)
   Route::middleware('role:admin,team_lead')->group(function () {
      Route::get('/cards/{card}/comments', [CommentController::class, 'indexCard'])
          ->name('comments.card.index');
      Route::post('/cards/{card}/comments', [CommentController::class, 'storeCard'])
          ->name('comments.card.store');
    // 🔹 Edit & Delete komentar (semua role boleh, tapi hanya milik sendiri yang bisa diubah)
      Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
      Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

   });

   // 🔹 Komentar untuk Subtask (semua role bisa: admin, team lead, developer, designer)
   Route::get('/subtasks/{subtask}/comments', [CommentController::class, 'indexSubtask'])
       ->name('comments.subtask.index');
   Route::post('/subtasks/{subtask}/comments', [CommentController::class, 'storeSubtask'])
       ->name('comments.subtask.store');
   Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
   Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
   });
});
