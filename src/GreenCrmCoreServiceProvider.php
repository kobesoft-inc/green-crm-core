<?php

namespace Green\CrmCore;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class GreenCrmCoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'green-crm-core');

        // Register Filament resources
        Filament::serving(function () {
            Filament::registerResources([
                \Green\CrmCore\Filament\Resources\ContactResource::class,
                \Green\CrmCore\Filament\Resources\CompanyResource::class,
            ]);
        });
    }
}
