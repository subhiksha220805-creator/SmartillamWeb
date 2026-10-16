<?php

namespace App\Providers;

use App\Services\ContentStore;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Vite::createAssetPathsUsing(
            static fn (string $path, ?bool $secure): string => '/'.ltrim($path, '/'),
        );

        View::composer('*', function (ViewInstance $view): void {
            $view->with('cmsContent', app(ContentStore::class)->all());
        });
    }
}
