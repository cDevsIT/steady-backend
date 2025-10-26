<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payments\PayPalController;
use App\Http\Controllers\Payments\StripePaymentController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyOrderController;
use App\Http\Controllers\Admin\TransitionsController;
use App\Http\Controllers\Admin\StateFeeController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\CompanyOwnerController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\RenewalController;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\DeveloperTestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
//Route::get('stripe-checkout', [DeveloperTestController::class, 'checkout'])->name('stripe.checkout');
//Route::get('success', [DeveloperTestController::class, 'success'])->name('stripe.success');
//Route::get('cancel', [DeveloperTestController::class, 'cancel'])->name('stripe.cancel');


Route::get('/link', function () {
//    if (function_exists('symlink')) {
//        echo 'symlink is enabled';
//    } else {
//        echo 'symlink is disabled';
//    }
//    die;
    \Illuminate\Support\Facades\Artisan::call("storage:link");
});

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call("cache:clear");
    return back()->with('success', "Sache Cleared Successfully");
});

// Root route - show login or redirect to admin dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/admin/dashboard');
    }
    return view('auth.login');
})->name('web.home');

// Public blog routes (redirect to admin or login)
Route::middleware('auth')->group(function () {
    Route::get('/about-us', function() { return redirect('/admin/dashboard'); })->name('web.about_us');
    Route::get('/contact-us', function() { return redirect('/admin/dashboard'); })->name('web.contact_us');
    Route::get('/terms-and-conditions', function() { return redirect('/admin/dashboard'); })->name('web.tramsCondition');
    Route::get('/privacy-policy', function() { return redirect('/admin/dashboard'); })->name('web.privacyPolicy');
    Route::get('/refund-policy', function() { return redirect('/admin/dashboard'); })->name('web.returnPolicy');
    Route::post('/contact-us', function() { return redirect('/admin/dashboard'); })->name('web.getInTouch');

    Route::get('/blog', function() { return redirect('/admin/dashboard'); })->name('web.blogs');
    Route::get('/{slug}', function() { return redirect('/admin/dashboard'); })->name('web.post');
    Route::get('/category/{slug}', function() { return redirect('/admin/dashboard'); })->name('web.categoryPosts');
    Route::get('/tag/{slug}', function() { return redirect('/admin/dashboard'); })->name('web.tagPosts');
    Route::get('/author/{slug}', function() { return redirect('/admin/dashboard'); })->name('web.authorPosts');
});


Route::group(['middleware' => ['auth', 'role:' . RoleEnum::CUSTOMER], 'prefix' => 'customer'], function () {
    Route::get('/dashboard', [FrontEndController::class, 'dashboard'])->name('web.dashboard');
    Route::get('/dashboard/company/{company}', [FrontEndController::class, 'companies'])->name('web.companies');
    Route::get('/dashboard/tickets/company/{company?}', [FrontEndController::class, 'tickets'])->name('web.tickets');
    Route::match(['get', 'post'], '/dashboard/tickets/make-a-ticket', [FrontEndController::class, 'makeTicket'])->name('web.makeTicket');
    Route::get('/dashboard/company/tickets/view-a-ticket/{ticket}', [FrontEndController::class, 'viewTicket'])->name('web.viewTicket');
    Route::post('/dashboard/company//tickets/{ticket}/make-a-comment', [FrontEndController::class, 'makeComment'])->name('web.makeComment');
    Route::get('/dashboard/company/{company}/renewal/{type}', [RenewalController::class, 'getRenewal'])->name('web.getRenewal');
    Route::post('/dashboard/company/{company}/renewal/{type}', [RenewalController::class, 'postRenewal'])->name('web.postRenewal');

    Route::get('/dashboard/renew-company/payment-success', [RenewalController::class, 'paymentSuccess'])->name('renew.success');
    Route::get('/dashboard/renew-company/payment-failed', [RenewalController::class, 'paymentCancel'])->name('renew.cancel');


});


Route::group(['middleware' => ['auth', 'role:' . RoleEnum::ADMIN], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::match(["get", "post"], '/admins', [CustomerController::class, 'admins'])->name('admin.user');
    Route::put('/admins/{admin}', [CustomerController::class, 'adminsUpdate'])->name('admin.update');
    Route::delete('/admins/{admin}', [CustomerController::class, 'adminDelete'])->name('admin.delete');

    Route::get('/customers/{customer?}', [CustomerController::class, 'customers'])->name('admin.customers');
    Route::match(['get', 'post'], '/customers/create/new', [CustomerController::class, 'createCustomer'])->name('admin.createCustomer');
    Route::put('/customers/{customer}/update', [CustomerController::class, 'customerUpdate'])->name('admin.customerUpdate');
    Route::get('/customers/{customer}/view', [CustomerController::class, 'customerView'])->name('admin.customerView');

    Route::get('/companies/{user?}', [CompanyController::class, 'companies'])->name('admin.companies');
    Route::post('/companies/{user?}', [CompanyController::class, 'companyCreate'])->name('admin.companyCreate');
    Route::get('/company/{company}/owners', [CompanyOwnerController::class, 'companyOwner'])->name('admin.companyOwner');
    Route::get('/owner/{owner}/info', [CompanyOwnerController::class, 'ownerInfo'])->name('admin.ownerInfo');
    Route::post('/owner/{owner}/send-emails', [CompanyOwnerController::class, 'ownerEmailSend'])->name('admin.ownerEmailSend');

    Route::get('/orders/{company?}', [CompanyOrderController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{order}/details', [CompanyOrderController::class, 'ordersDetails'])->name('admin.ordersDetails');
    Route::post('/orders/{order}/document/{document_type}/upload', [CompanyOrderController::class, 'orderDocumentUpdate'])->name('admin.orderDocumentUpdate');
    Route::post('/company/order/{order}/date/update', [CompanyOrderController::class, 'companyDateUpdate'])->name('admin.companyDateUpdate');
    Route::post('/company-order/{order}/status/update', [CompanyOrderController::class, 'orderStatusUpdate'])->name('admin.orderStatusUpdate');
    Route::post('/company-details/{company}/status/update', [CompanyOrderController::class, 'updateCompanyDetailsOnOrderDetails'])->name('admin.updateCompanyDetailsOnOrderDetails');

    Route::get('/transitions/{order?}', [TransitionsController::class, 'transitions'])->name('admin.transitions');
    Route::resource('fees', StateFeeController::class)->names('admin.fees');
    Route::resource('settings', WebsiteSettingController::class)->names('admin.settings');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('categories');
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->names('blogs');
    Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class)->names('tickets');
    // Tickets - Admin create
    Route::post('/tickets/admin-create', [\App\Http\Controllers\Admin\TicketController::class, 'adminStore'])->name('tickets.adminStore');
    
    // Wallet Management Routes
    Route::get('/wallets', [WalletController::class, 'index'])->name('admin.wallets.index');
    Route::post('/wallets', [WalletController::class, 'store'])->name('admin.wallets.store');
    Route::get('/wallets/{wallet}', [WalletController::class, 'show'])->name('admin.wallets.show');
    Route::put('/wallets/{wallet}', [WalletController::class, 'update'])->name('admin.wallets.update');
    Route::get('/wallets/{wallet}/transactions', [WalletController::class, 'transactions'])->name('admin.wallets.transactions');
    Route::get('/wallets/{wallet}/activity-log', [WalletController::class, 'activityLog'])->name('admin.wallets.activityLog');
    Route::post('/wallets/{wallet}/adjust-balance', [WalletController::class, 'adjustBalance'])->name('admin.wallets.adjustBalance');
    Route::post('/wallets/{wallet}/toggle-freeze', [WalletController::class, 'toggleFreeze'])->name('admin.wallets.toggleFreeze');
    
    Route::get('try-to-register-list', [\App\Http\Controllers\Admin\PrimaryContactController::class, 'index'])->name('admin.try_to_register_list');
    
    // Single Services Routes
    Route::resource('services', ServiceController::class)->names('admin.services');
    Route::post('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('admin.services.toggleStatus');
    Route::post('/services/{service}/toggle-visibility', [ServiceController::class, 'toggleVisibility'])->name('admin.services.toggleVisibility');
});

Route::post('/password-update/for/individual', [HelperController::class, 'passwordUpdate'])->name("passwordUpdate");


Route::group(['prefix' => 'help'], function () {
    Route::get('/email_check', [HelperController::class, 'emailCheck'])->name('help.emailCheck');
    Route::post('/store-new-user', [HelperController::class, 'storeUser'])->name('help.storeUser');
    Route::post('/store-primary-data-to_database', [HelperController::class, 'storePrimaryData'])->name('help.storePrimaryData');

});


// Redirect /home to admin dashboard
Route::get('/home', function () {
    if (auth()->check()) {
        return redirect('/admin/dashboard');
    }
    return redirect('/');
})->name('home');

// Catch-all route: Redirect all unmatched routes to admin dashboard
Route::fallback(function () {
    if (auth()->check()) {
        return redirect('/admin/dashboard');
    }
    return redirect('/');
});


