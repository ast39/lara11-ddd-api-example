<?php

namespace App\Providers;

use DDD\Sso\Providers\UserServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider {

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
        $paths = [database_path('migrations')];
        $modulesPath = app_path('Modules');

        if (is_dir($modulesPath)) {
            $modules = scandir($modulesPath);

            foreach ($modules as $module) {
                if ($module === '.' || $module === '..') {
                    continue;
                }

                $migrationsPath = $modulesPath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'Infrastructure' . DIRECTORY_SEPARATOR . 'Persistence' . DIRECTORY_SEPARATOR . 'Migrations';

                if (is_dir($migrationsPath)) {
                    $paths[] = $migrationsPath;
                }
            }
        }

        $this->loadMigrationsFrom($paths);
    }
}
