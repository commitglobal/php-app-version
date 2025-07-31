<?php

declare(strict_types=1);

namespace CommitGlobal\AppVersion;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Sentry\Laravel\Integration as SentryIntegration;

class AppVersionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->registerSingleton();

        $this->registerSentryIntegration();
        $this->registerFilamentIntegration();
    }

    public function boot(): void
    {
        $this->bootPublishing();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/app-version.php', 'app-version');
    }

    private function registerSingleton(): void
    {
        $this->app->singleton('version', function () {
            $version = Config::get('app-version.file');

            if (! file_exists($version)) {
                return Config::get('app-version.fallback');
            }

            return trim(file_get_contents($version));
        });
    }

    private function registerSentryIntegration(): void
    {
        if (! class_exists(SentryIntegration::class)) {
            return;
        }

        Config::set('sentry.release', $this->app->make('version'));
    }

    private function registerFilamentIntegration(): void
    {
        if (! class_exists(FilamentView::class)) {
            return;
        }

        FilamentView::registerRenderHook(
            Config::get('app-version.filament-hook', PanelsRenderHook::FOOTER),
            fn () => View::make('app-version::banner', ['version' => $this->app->make('version')]),
        );
    }

    private function bootPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/app-version.php' => $this->app->configPath('app-version.php'),
            ], 'app-version');
        }
    }
}
