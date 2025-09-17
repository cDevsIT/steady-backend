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

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Blog::all();
    $categories = \App\Models\Category::all();
    $tags = \App\Models\Tag::all();
    $authors = \App\Models\User::where('role', RoleEnum::ADMIN)->get();


    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    $xml .= '<url>';
    $xml .= '<loc>' . route('web.home') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';


    $xml .= '<url>';
    $xml .= '<loc>' . route('web.about_us') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';

    $xml .= '<url>';
    $xml .= '<loc>' . route('web.contact_us') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';


    $xml .= '<url>';
    $xml .= '<loc>' . route('web.tramsCondition') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';

    $xml .= '<url>';
    $xml .= '<loc>' . route('web.privacyPolicy') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';

    $xml .= '<url>';
    $xml .= '<loc>' . route('web.getInTouch') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';


    $xml .= '<url>';
    $xml .= '<loc>' . route('web.returnPolicy') . '</loc>';
    $xml .= '<lastmod>' . \Carbon\Carbon::now()->tz('UTC')->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>weekly</changefreq>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';


    foreach ($posts as $post) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('web.post', $post->slug) . '</loc>';
        $xml .= '<lastmod>' . $post->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }
    foreach ($categories as $category) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('web.categoryPosts', $category->slug) . '</loc>';
        $xml .= '<lastmod>' . $category->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }
    foreach ($tags as $tag) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('web.tagPosts', $tag->slug) . '</loc>';
        $xml .= '<lastmod>' . $tag->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }
    foreach ($authors as $author) {
        if ($author->slug) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('web.authorPosts', $author->slug) . '</loc>';
            $xml .= '<lastmod>' . $author->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }
    }


    $xml .= '</urlset>';

    return Response::make($xml, 200, [
        'Content-Type' => 'application/xml'
    ]);
});
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

Route::get('/table', function () {
    $table = '<div class="elementor-widget-container"><p>If you’re a non-US resident looking to register your business in the US, Delaware and Wyoming should be at the top of your list. <h1>Though they differ</h1> in some ways, both states are optimized for corporate growth.</p><p>Delaware and Wyoming offer low corporate and income taxes, marketing advantages, a business-friendly legal system, reduced paperwork costs, and excellent property and asset protection. As a non-US citizen, your business and personal goals will be key in deciding which state to choose.</p><p>Let’s explore whether Delaware or Wyoming is the best fit for you.</p><span id="elementor-toc__heading-anchor-0" class="elementor-menu-anchor "></span><h2>Taxation In Delaware</h2><p>For businesses registered in Delaware, you’ll need to pay two main taxes: the Franchise Tax, which is based on the number of authorized shares, and the Corporate Income Tax, which is 8.7% of the federal taxable income within the state. Delaware does not have state or local sales tax.</p><p>Additionally, all businesses must obtain an annual business license, which typically costs $75.00 for one location. There’s also a gross receipts tax applied to service providers.</p><span id="elementor-toc__heading-anchor-1" class="elementor-menu-anchor "></span><h2 class="wp-block-heading">Taxation In Wyoming</h2><p>One of the most attractive features for LLCs in Wyoming is the low sales tax rate, which is around 5%, making it one of the lowest in the US. Additionally, Wyoming does not impose a corporate income tax or franchise tax.</p><p>For businesses not planning to relocate to Wyoming, the state offers Wyoming Trusts. These modern trust laws enable the transfer of assets from high-income tax locations, helping businesses avoid excessive taxation. Furthermore, Wyoming does not have a gross receipts tax or excise tax.</p><span id="elementor-toc__heading-anchor-2" class="elementor-menu-anchor "></span><h2 class="wp-block-heading">Pricing Factor</h2><figure class="wp-block-table"><table class="has-fixed-layout"><thead><tr><th class="has-text-align-center" data-align="center">Taxes</th><th class="has-text-align-center" data-align="center">Wyoming</th><th class="has-text-align-center" data-align="center">Delaware</th></tr></thead><tbody><tr><td class="has-text-align-center" data-align="center">Franchise tax</td><td class="has-text-align-center" data-align="center">No</td><td class="has-text-align-center" data-align="center">Yes</td></tr><tr><td class="has-text-align-center" data-align="center">The initial filing fee rate</td><td class="has-text-align-center" data-align="center">Minimal</td><td class="has-text-align-center" data-align="center">Moderate</td></tr><tr><td class="has-text-align-center" data-align="center">Annual fees</td><td class="has-text-align-center" data-align="center">Minimal</td><td class="has-text-align-center" data-align="center">Moderate</td></tr><tr><td class="has-text-align-center" data-align="center">Corporate share tax</td><td class="has-text-align-center" data-align="center">No</td><td class="has-text-align-center" data-align="center">No</td></tr><tr><td class="has-text-align-center" data-align="center">Personal income tax</td><td class="has-text-align-center" data-align="center">No</td><td class="has-text-align-center" data-align="center">Yes</td></tr><tr><td class="has-text-align-center" data-align="center">Corporate income tax</td><td class="has-text-align-center" data-align="center">No</td><td class="has-text-align-center" data-align="center">Yes</td></tr><tr><td class="has-text-align-center" data-align="center">Local tax</td><td class="has-text-align-center" data-align="center">Yes</td><td class="has-text-align-center" data-align="center">No</td></tr><tr><td class="has-text-align-center" data-align="center">Stock tax</td><td class="has-text-align-center" data-align="center">No</td><td class="has-text-align-center" data-align="center">No</td></tr></tbody></table></figure><span id="elementor-toc__heading-anchor-3" class="elementor-menu-anchor "></span><h2 class="wp-block-heading">Benefits of Doing Business in Delaware</h2><p>Delaware boasts the 10th strongest economy in the US and ranks among the top 10 states for equality. Impressively, 60% of Fortune 500 companies and 50% of publicly traded companies in the US are incorporated in Delaware.</p><h4 class="wp-block-heading">Incorporation Law Made Easy</h4><p>Delaware is renowned for its favorable corporate laws and business-friendly environment. The Delaware General Corporation Law is crafted to attract new businesses to the state. The state’s highly efficient court system, particularly the Court of Chancery, specializes in corporate cases, ensuring accuracy and predictability.</p><p>Established in 1972, the Court of Chancery is dedicated to resolving legal disputes and is recognized for its expertise in corporate matters. Delaware law often favors management in shareholder disputes, making it an appealing choice for businesses.</p><p>Additionally, Delaware is well-equipped to handle high levels of mergers and acquisitions through procedures such as schemes of arrangement. Combined with its favorable corporate laws, Delaware stands out as a top choice for businesses looking to incorporate.</p><h4 class="wp-block-heading">Ease of Doing Business</h4><p>Delaware is renowned for its ease of doing business, making it a prime destination for new enterprises. Incorporating a business in Delaware is straightforward and affordable, with a minimal fee of $100.</p><p>The state offers unique advantages for international businesses, including permits, streamlined transactions, conversions, and transfers. Business combinations with both foreign and domestic entities can proceed without judicial approval.</p><p>Delaware’s statutes are investor-friendly, allowing for various post-transaction legal opinions. Companies incorporated in Delaware do not need a physical office in the state, only a registered agent.</p><p>Business ownership and management can include individuals of any nationality, and authorities can obtain written consent electronically for votes and other actions. With its business-friendly environment and straightforward processes, Delaware is an ideal location for starting a business.</p><h4 class="wp-block-heading">Resources and Legal Framework</h4><p>Delaware is a business-friendly state that offers extensive resources and support for both entrepreneurs and established businesses. The state’s Division of Small Businesses is dedicated to the success of startups and online ventures.</p><p>Delaware boasts a wide range of government and non-government organizations, including registered agents, branding and marketing firms, and law offices. These resources are readily accessible online, ensuring convenience for all businesses.</p><p>Whether you’re launching a new venture or expanding an existing one, Delaware provides the essential tools and services for your success. Join Delaware’s thriving business community and benefit from its supportive environment.</p><span id="elementor-toc__heading-anchor-4" class="elementor-menu-anchor "></span><h2 class="wp-block-heading">Benefits of Doing Business in Wyoming</h2><p>If you’re looking for a state that warmly welcomes new businesses and offers an excellent tax climate, Wyoming is the perfect choice. Wyoming’s business environment is designed to attract numerous corporations with its straightforward administrative procedures and business-friendly policies.</p><h4 class="wp-block-heading">Low-Cost Incorporation in Wyoming</h4><p>Wyoming boasts highly business-friendly corporate laws that foster rapid company growth. These laws are crafted to ensure smooth corporate operations, making most business activities virtually restriction-free. For over a decade, the state has maintained low and consistent filing and incorporation fees, supported by a substantial $10 billion rainy day fund. This stability allows businesses to thrive without the worry of increasing fees.</p><p>Wyoming’s legal system acknowledges the concept of a corporation’s domicile status, enabling registered companies to relocate to Wyoming later on. This flexibility makes Wyoming an appealing option for businesses planning to expand. Additionally, the state’s liberal corporate laws, such as the allowance of nominee shareholders and no requirement for share certificates, create a welcoming environment for businesses of all sizes.</p><h4 class="wp-block-heading">Business-Friendly Environment in Wyoming</h4><p>Wyoming has a long-standing reputation as a favorable state for business owners. It was the first state to introduce the Limited Liability Company (LLC) in 1977, setting a precedent that many other states have since followed. Wyoming is renowned for its strong asset protection and trust laws that can endure for centuries.</p><p>Starting a business in Wyoming is straightforward, with no minimum capital requirements. The state highly values the privacy of business owners, allowing corporations to keep member and stockholder information confidential from public records.</p><p>Additionally, Wyoming offers unique advantages for single-member LLCs, such as charging order protection, which helps safeguard assets and the company in the event of a lawsuit.</p><h4 class="wp-block-heading">Business Growth Resources in Wyoming</h4><p>Wyoming offers extensive support and resources for both new and established businesses. Entrepreneurs can take advantage of various services, including licensing and permitting assistance, SBIR/STTR funding, and expert counseling.</p><p>The Wyoming Small Business Administration (SBA) provides a wealth of online resources and coordinates programs and services through its partner agencies, such as PTAC, SBDC, SCORE, and WWBC. These agencies specialize in meeting the specific needs of small businesses and startups, offering help with marketing, financial planning, and international trade.</p><p>The SBDC, in particular, assists startups and small businesses with marketing plans, financial strategies, and international trade. The WWBC focuses on helping entrepreneurs develop their small businesses in Wyoming. These agencies offer a vast online network and resources for all registered corporations.</p><span id="elementor-toc__heading-anchor-5" class="elementor-menu-anchor "></span><h2 class="wp-block-heading">Which State Should You Choose?</h2><p>Wyoming boasts the strongest LLC statute in the US and offers lower initial and annual fees compared to Delaware. Although Delaware has a more sophisticated corporate law and court system, as well as a simpler tax reporting process, Wyoming has the longest history of LLC case law.</p><p>The size of your business is also a key consideration. Small businesses will find Wyoming more advantageous due to its minimal fees and various corporate benefits. In contrast, larger and more structured companies can greatly benefit from Delaware’s legal procedures, asset and property protection, and shareholder advantages.</p><span id="elementor-toc__heading-anchor-6" class="elementor-menu-anchor "></span><h2 class="wp-block-heading">Final Words</h2><p>For non-US residents with international businesses, both Delaware and Wyoming offer significant market advantages, making it easier to access the US market networks. The financial benefits from their unique tax laws and legal protections are substantial. If you’re seeking the lowest tax fees, Wyoming is the best choice. For minimal corporate hassle, Delaware stands out.</p><p>Your choice should depend on your business goals. Consider the long-term benefits to determine whether Delaware or Wyoming is the better fit for you.</p><p>Need expert advice to answer your specific questions and guide you in setting up your business as a non-US citizen? <a href="https://steadyformation.com/">Steady Formation</a> can help you establish your business from scratch or enhance your existing one.</p></div>';
    return view('devtest', compact('table'));

});
Route::get('/', function () {
    return view('auth.login');
})->name('web.home');

Route::get('/about-us', [FrontEndController::class, 'aboutUs'])->name('web.about_us');
Route::get('/contact-us', [FrontEndController::class, 'contactUs'])->name('web.contact_us');
Route::get('/terms-and-conditions', [FrontEndController::class, 'tramsAndCondition'])->name('web.tramsCondition');
Route::get('/privacy-policy', [FrontEndController::class, 'privacyPolicy'])->name('web.privacyPolicy');
Route::get('/refund-policy', [FrontEndController::class, 'returnPolicy'])->name('web.returnPolicy');
Route::post('/contact-us', [FrontEndController::class, 'getInTouch'])->name('web.getInTouch');

Route::get('/blog', [FrontEndController::class, 'blogs'])->name('web.blogs');
Route::get('/{slug}', [FrontEndController::class, 'post'])->name('web.post');
Route::get('/category/{slug}', [FrontEndController::class, 'categoryPosts'])->name('web.categoryPosts');
Route::get('/tag/{slug}', [FrontEndController::class, 'tagPosts'])->name('web.tagPosts');
Route::get('/author/{slug}', [FrontEndController::class, 'authorPosts'])->name('web.authorPosts');


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
    Route::get('try-to-register-list', [\App\Http\Controllers\Admin\PrimaryContactController::class, 'index'])->name('admin.try_to_register_list');
});

//Stripe Payment Getaway
Route::group(['prefix' => 'stripe'], function () {
//    Route::get('stripe-checkout', [DeveloperTestController::class, 'checkout'])->name('stripe.checkout');
    Route::post("pay/stripe", [StripePaymentController::class, 'pay'])->name('pay.stripe');
    Route::get('success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
    Route::post('/refund', [StripePaymentController::class, 'refund'])->name('stripe.refund');

});

//Paypal Payment Getaway
Route::group(['prefix' => 'paypal'], function () {
    Route::get('/create-payment', [PayPalController::class, 'createPayment'])->name('paypal.pay');
    Route::get('/success', [PayPalController::class, 'success'])->name('paypal.success');
    Route::get('/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

});

Route::get('pay/payment-success', [HelperController::class, 'paymentSuccess'])->name("payment_success");
Route::get('pay/payment-error', [HelperController::class, 'paymentError'])->name("payment_error");
Route::post('/password-update/for/individual', [HelperController::class, 'passwordUpdate'])->name("passwordUpdate");


Route::group(['prefix' => 'help'], function () {
    Route::get('/email_check', [HelperController::class, 'emailCheck'])->name('help.emailCheck');
    Route::post('/store-new-user', [HelperController::class, 'storeUser'])->name('help.storeUser');
    Route::post('/store-primary-data-to_database', [HelperController::class, 'storePrimaryData'])->name('help.storePrimaryData');

});


Route::get('test/by/dev', [\App\Http\Controllers\DeveloperTestController::class, 'test'])->name("test");

Route::post('payment/{type}', [\App\Http\Controllers\PaymentController::class, 'payNow'])->name("payNow");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


