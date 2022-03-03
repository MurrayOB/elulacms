<?php

namespace Murrayobrien\Elulacms; 

use Illuminate\Support\ServiceProvider; 

class ElulacmsServiceProvider extends ServiceProvider{
    
    public function boot(){
        //Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/elulacms.php');
        //Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'elulacms');
        //Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        //Public
        // __DIR__.'/../public/config/' => config_path('vendor/elulacms'),
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/elulacms'),
        ], 'public');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class,
            ]);
        }
    }

    public function register(){
    }
}