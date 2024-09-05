<?php

namespace Cloudteam\CoreV2;

use Cloudteam\CoreV2\Console\Commands\CreateMultipleMigration;
use Cloudteam\CoreV2\Console\Commands\CrudControllerCommand;
use Cloudteam\CoreV2\Console\Commands\CrudMakeCommand;
use Cloudteam\CoreV2\Console\Commands\CrudTableCommand;
use Cloudteam\CoreV2\Console\Commands\CrudTestCommand;
use Cloudteam\CoreV2\Console\Commands\CrudViewCommand;
use Cloudteam\CoreV2\Console\Commands\GenerateMultipleModel;
use Cloudteam\CoreV2\Console\Commands\MakeEnumCommand;
use Cloudteam\CoreV2\Console\Commands\MakeLocalScopeCommand;
use Cloudteam\CoreV2\Console\Commands\MakeModelAttributeCommand;
use Cloudteam\CoreV2\Console\Commands\MakeModelMethodCommand;
use Cloudteam\CoreV2\Console\Commands\MakeModelRelationshipCommand;
use Cloudteam\CoreV2\Console\Commands\MakeModelServiceCommand;
use Cloudteam\CoreV2\Console\Commands\MakeMultipleMigration;
use Cloudteam\CoreV2\Console\Commands\MakeMultipleModel;
use Illuminate\Support\ServiceProvider;

class CoreV2ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
         //$this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'core-v2');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'core-v2');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('core-v2.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/core-v2'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/core-v2'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/core-v2'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands(
                [
                    CrudMakeCommand::class,
                    CrudControllerCommand::class,
                    CrudTableCommand::class,
                    CrudViewCommand::class,
                    CrudTestCommand::class,

                    MakeLocalScopeCommand::class,
                    MakeModelMethodCommand::class,
                    MakeModelAttributeCommand::class,
                    MakeModelRelationshipCommand::class,
                    MakeModelServiceCommand::class,
                    MakeEnumCommand::class,

                    MakeMultipleMigration::class,
                    MakeMultipleModel::class,

                    CreateMultipleMigration::class,
                    GenerateMultipleModel::class,
                ]
            );
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'core-v2');

        // Register the main class to use with the facade
        $this->app->singleton('core-v2', function () {
            return new CoreV2;
        });
    }
}
