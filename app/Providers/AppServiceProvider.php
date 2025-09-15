<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\WebsiteSetting;
use App\Services\SeoService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        $setting = WebsiteSetting::latest()->first();
        View::share('setting', $setting);


        Blade::directive('toc', function ($expression) {
            return "<?php echo generateToc($expression)['toc']; ?>";
        });

        Blade::directive('contentWithIds', function ($expression) {
            return "<?php echo generateToc($expression)['content']; ?>";
        });


        $this->app->singleton(SeoService::class, function ($app) {
            return new SeoService();
        });
    }
}
