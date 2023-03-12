<?php

namespace App\Providers;

use App\View\Components\dashboard\DashboardItem;
use App\View\Components\photo\CommentsListComponent;
use App\View\Components\photo\PhotoDetailsComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::component('components.photo.comments-list-component',CommentsListComponent::class);
        Blade::component('components.dashboard.dashboard-item',DashboardItem::class);
        Blade::component('components.photo.photo-details-component',PhotoDetailsComponent::class);
    }
}
