<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompensationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PasswordManagementController;

// Public Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    // Logout route (only available when logged in)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // The main page will now show the compensation list
    Route::get('/', [CompensationController::class, 'index'])->name('home');

    // Compensation Form Routes
    Route::get('/compensations', [CompensationController::class, 'index'])->name('compensation.index');
    Route::get('/compensations/register', [CompensationController::class, 'register'])->name('compensation.register');
    Route::get('/compensation/create', [CompensationController::class, 'create'])->name('compensation.create');
    Route::post('/compensation/store', [CompensationController::class, 'store'])->name('compensation.store');
    Route::get('/compensation/{id}/preview', [CompensationController::class, 'preview'])->name('compensation.preview');
    Route::get('/compensation/{id}/edit', [CompensationController::class, 'edit'])->name('compensation.edit');
    Route::put('/compensation/{id}', [CompensationController::class, 'update'])->name('compensation.update');
    Route::delete('/compensation/{id}', [CompensationController::class, 'destroy'])->name('compensation.destroy');
    Route::post('/compensation/{id}/restore', [CompensationController::class, 'restore'])->name('compensation.restore');

    // Kanungo Opinion Routes
    Route::get('/compensation/{id}/kanungo-opinion', [CompensationController::class, 'getKanungoOpinion'])->name('compensation.kanungo-opinion.get');
    Route::put('/compensation/{id}/kanungo-opinion', [CompensationController::class, 'updateKanungoOpinion'])->name('compensation.kanungo-opinion.update');

    // Order Routes
    Route::get('/compensation/{id}/order', [CompensationController::class, 'getOrder'])->name('compensation.order.get');
    Route::put('/compensation/{id}/order', [CompensationController::class, 'updateOrder'])->name('compensation.order.update');

    // Final Order Routes
    Route::get('/compensation/{id}/final-order', [CompensationController::class, 'getFinalOrder'])->name('compensation.final-order.get');
    Route::put('/compensation/{id}/final-order', [CompensationController::class, 'updateFinalOrder'])->name('compensation.final-order.update');
    Route::get('/compensation/{id}/final-order/preview', [CompensationController::class, 'finalOrderPreview'])->name('compensation.final-order.preview');
    Route::get('/compensation/{id}/final-order/pdf', [CompensationController::class, 'generateFinalOrderPdf'])->name('compensation.final-order.pdf');

    // Action Routes
    Route::get('/compensation/{id}/present', [CompensationController::class, 'present'])->name('compensation.present');
    Route::post('/compensation/{id}/present', [CompensationController::class, 'storePresent'])->name('compensation.present.store');
    Route::get('/compensation/{id}/notice/preview', [CompensationController::class, 'noticePreview'])->name('compensation.notice.preview');
    Route::get('/compensation/{id}/notice/pdf', [CompensationController::class, 'generateNoticePdf'])->name('compensation.notice.pdf');
    Route::get('/compensation/{id}/present/preview', [CompensationController::class, 'presentPreview'])->name('compensation.present.preview');
    Route::get('/compensation/{id}/present/pdf', [CompensationController::class, 'generatePresentPdf'])->name('compensation.present.pdf');
    Route::get('/compensation/{id}/analysis', [CompensationController::class, 'analysis'])->name('compensation.analysis');
    Route::get('/compensation/{id}/analysis/pdf', [CompensationController::class, 'analysisPdf'])->name('compensation.analysis.pdf');
    Route::get('/compensation/{id}/analysis/excel', [CompensationController::class, 'analysisExcel'])->name('compensation.analysis.excel');
    Route::get('/compensation/{id}/preview/pdf', [CompensationController::class, 'generatePreviewPdf'])->name('compensation.preview.pdf');

    // Super User Routes (User Management)
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
    Route::delete('/admin/users/{user}/reject', [UserManagementController::class, 'reject'])->name('admin.users.reject');
    Route::post('/admin/users/{user}/revoke', [UserManagementController::class, 'revoke'])->name('admin.users.revoke');
    Route::post('/admin/users/{user}/make-super', [UserManagementController::class, 'makeSuperUser'])->name('admin.users.make-super');
    Route::post('/admin/users/{user}/remove-super', [UserManagementController::class, 'removeSuperUser'])->name('admin.users.remove-super');
    Route::post('/admin/users/{user}/reset-password', [PasswordManagementController::class, 'adminResetPassword'])->name('admin.users.reset-password');

    // Password Management Routes
    Route::get('/password/change', [PasswordManagementController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordManagementController::class, 'changePassword']);
    Route::get('/password/forced-change', [PasswordManagementController::class, 'showForcedChangeForm'])->name('password.forced-change');
    Route::post('/password/forced-change', [PasswordManagementController::class, 'forcedPasswordChange']);
});