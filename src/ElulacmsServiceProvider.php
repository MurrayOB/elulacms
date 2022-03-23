<?php

namespace Murrayobrien\Elulacms; 

use Illuminate\Support\ServiceProvider; 
use Artisan;

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
            __DIR__.'/../public/config/elulacms.php' => config_path('elulacms.php'),
        ], 'public');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class,
            ]);
        }

        //When in Development
        if(env('APP_DEBUG')){
            Artisan::call('vendor:publish', array('--tag' => 'public', '--force' => true));
        }
    }

    public function register(){
    }
}