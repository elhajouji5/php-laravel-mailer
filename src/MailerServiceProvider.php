<?php

namespace Elhajouji5\phpLaravelMailer;

use Illuminate\Support\ServiceProvider;

class MailerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */


    public function boot()
    {
        // Load routes once the application runs
        require __DIR__ . '/routes.php';

        // Load views once the application runs
        $this->loadViewsFrom(__DIR__.'/views', 'view');

        // Load migration once the artisan migrate commands is executed
        $this->loadMigrationsFrom(__DIR__.'/database/migrations/');

        // Move the mail views(subscriber, support) to the resources/views path when the artisan publish command executes
        $this->publishes([
            __DIR__ . "/views" => public_path() . "/vendor/mailViews"
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }
}

