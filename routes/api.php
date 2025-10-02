<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CompanyFormationController;
use App\Http\Controllers\Api\PayPalController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\StateFeeController;
use App\Http\Controllers\Api\CompanyStatusController;
use App\Http\Controllers\Api\DocumentsController;
use App\Http\Controllers\Api\TicketsController;
use App\Http\Controllers\Api\TransitionsController as ApiTransitionsController;
use App\Http\Controllers\Api\OwnerDocumentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::get('/validate-temp-token', [AuthController::class, 'validateTempToken']);
    
    // Password Reset Routes
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// User specific routes
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/companies', [AuthController::class, 'userCompanies']);
    Route::get('/company', [AuthController::class, 'userCompany']);
    Route::get('/profile', [AuthController::class, 'userProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/password', [AuthController::class, 'updatePassword']);
    Route::post('/avatar', [AuthController::class, 'uploadAvatar']);
});

// Blog Routes
Route::prefix('blogs')->group(function () {
    // Public routes
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/{blog:slug}', [BlogController::class, 'show']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [BlogController::class, 'store']);
        Route::put('/{blog}', [BlogController::class, 'update']);
        Route::delete('/{blog}', [BlogController::class, 'destroy']);
    });
});

// Company Formation routes
Route::post('/company-formation/store', [CompanyFormationController::class, 'store']); // No auth required - user created during submission

// Payment routes
Route::post('/payments/stripe/create-session', [StripeController::class, 'createCheckoutSession']);
Route::post('/payments/paypal/create-payment', [PayPalController::class, 'createPayment']);
Route::get('/payments/stripe/success', [StripeController::class, 'success']);
Route::get('/payments/stripe/cancel', [StripeController::class, 'cancel']);
Route::get('/payments/paypal/success', [PayPalController::class, 'success']);
Route::get('/payments/paypal/cancel', [PayPalController::class, 'cancel']);

// State Fees routes
Route::prefix('state-fees')->group(function () {
    Route::get('/by-field', [StateFeeController::class, 'getFeesByField']);
    Route::get('/all', [StateFeeController::class, 'getAllFees']);
    Route::get('/state/{stateName}', [StateFeeController::class, 'getFeesByState']);
});

// Company Status routes
Route::prefix('company-status')->group(function () {
    Route::get('/status', [CompanyStatusController::class, 'getCompanyStatus']);
    Route::get('/user-orders', [CompanyStatusController::class, 'getUserOrders']);
});

// Documents routes
Route::prefix('documents')->group(function () {
    Route::get('/user-documents', [DocumentsController::class, 'getUserDocuments']);
    Route::get('/download/{orderId}/{type}', [DocumentsController::class, 'downloadDocument']);
    Route::get('/file/{filename}', [DocumentsController::class, 'downloadFile']);
});

// Owner Documents routes
Route::prefix('owner-documents')->group(function () {
    Route::post('/upload', [OwnerDocumentsController::class, 'uploadDocuments']);
    Route::get('/get', [OwnerDocumentsController::class, 'getDocuments']);
    Route::post('/store-owners', [OwnerDocumentsController::class, 'storeOwners']);
});

// Company Owners routes
Route::prefix('company')->group(function () {
    Route::get('/{companyId}/owners', [OwnerDocumentsController::class, 'getCompanyOwners']);
});

// Tickets routes
Route::middleware('auth:sanctum')->prefix('tickets')->group(function () {
    Route::get('/user-tickets', [TicketsController::class, 'getUserTickets']);
    Route::get('/{ticketId}', [TicketsController::class, 'getTicket']);
    Route::post('/', [TicketsController::class, 'createTicket']);
    Route::post('/{ticketId}/comments', [TicketsController::class, 'addComment']);
    Route::get('/{ticketId}/download/{type}', [TicketsController::class, 'downloadAttachment']);
    Route::get('/comments/{commentId}/download', [TicketsController::class, 'downloadCommentAttachment']);
});

// Transitions (Payment History) routes
Route::prefix('payments')->group(function () {
    // Public read endpoint (expects company_id or user_id); no design change required on frontend
    Route::get('/history', [ApiTransitionsController::class, 'getUserTransitions']);
});


