<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\DocumentsController;
use App\Http\Controllers\API\RequestDocumentController;
use App\Http\Controllers\API\CertificateLogsController;
use App\Http\Controllers\API\RejectedAccountController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\BlotterController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\activityLogsController;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Account Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/accounts/{id}/update-information', [AccountController::class, 'updateInformation']);
    Route::put('/accounts/{id}/update-status', [AccountController::class, 'updateStatus']);
    Route::put('/accounts/{id}/update-password', [AccountController::class, 'updatePassword']);
    Route::post('/accounts/{id}/update-profile-picture', [AccountController::class, 'updateProfilePicture']);
    Route::delete('/accounts/{id}/reject', [AccountController::class, 'rejectAccount']);
    Route::get('/accounts/all', [AccountController::class, 'index']);
    Route::get('/user', [AccountController::class, 'current']);
    Route::get('/user/{id}', [AccountController::class, 'show']);

    // Document Routes
    Route::get('/documents', [DocumentsController::class, 'index']);
    Route::get('/documents/{id}', [DocumentsController::class, 'show']);
    Route::post('/documents/create', [DocumentsController::class, 'store']);
    Route::put('/documents/update/{id}', [DocumentsController::class, 'update']);
    Route::delete('/documents/destroy/{id}', [DocumentsController::class, 'destroy']);

    // Request Document Routes
    Route::get('/request-documents', [RequestDocumentController::class, 'index']);
    Route::get('/request-documents/{id}', [RequestDocumentController::class, 'show']);
    Route::post('/request-documents/create', [RequestDocumentController::class, 'store']);
    Route::put('/request-documents/status/{id}', [RequestDocumentController::class, 'changeStatus']);

    // Certificate Logs Routes
    Route::post('/certificate-logs/create', [CertificateLogsController::class, 'create']);
    Route::get('/certificate-logs', [CertificateLogsController::class, 'index']);
    Route::get('/certificate-logs/{id}', [CertificateLogsController::class, 'show']);

    // Officials Routes
    Route::post('/officials/create', [\App\Http\Controllers\API\OfficialsController::class, 'store']);
    Route::post('/officials/update/{id}', [\App\Http\Controllers\API\OfficialsController::class, 'update']);
    Route::post('/officials/update/status/{id}', [\App\Http\Controllers\API\OfficialsController::class, 'updateStatus']);
    Route::get('/officials/get', [\App\Http\Controllers\API\OfficialsController::class, 'index']);
    Route::get('/officials/get/{id}', [\App\Http\Controllers\API\OfficialsController::class, 'show']);

    // Rejected Accounts Routes
    Route::get('/rejected-accounts', [RejectedAccountController::class, 'index']);

    // Announcement Routes
    Route::get('/announcements', [AnnouncementController::class, 'index']);       // paginated + filter
    Route::post('/announcements/create', [AnnouncementController::class, 'store']);
    Route::post('/announcements/show', [AnnouncementController::class, 'show']);
    Route::put('/announcements/update', [AnnouncementController::class, 'update']);
    Route::delete('/announcements/delete', [AnnouncementController::class, 'destroy']);

    // Blotter Routes
    Route::get('/blotters', [BlotterController::class, 'index']);
    Route::post('/blotters/create', [BlotterController::class, 'store']);
    Route::post('/blotters/show', [BlotterController::class, 'show']);
    Route::put('/blotters/update', [BlotterController::class, 'update']);
    Route::delete('/blotters/delete', [BlotterController::class, 'destroy']);

    // Feedback routes
    Route::get('/feedback', [FeedbackController::class, 'index']);
    Route::post('/feedback/create', [FeedbackController::class, 'store']);
    Route::post('/feedback/update', [FeedbackController::class, 'update']);
    Route::post('/feedback/delete', [FeedbackController::class, 'destroy']);

    // Activity Logs Routes
    Route::get('/activitylogs', [activityLogsController::class, 'index']);
    Route::post('/activitylogs/create', [activityLogsController::class, 'store']);
});

// Temporary bug fix sa Route [Login]
// Nag re-redirect sa login blade instead na json kaya eto nalang muna
Route::get('redirect', function () {
    return response()->json([
        'message'=>"unauthorized access"
    ], 401);
})->name('login');
