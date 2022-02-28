<?php

namespace Murrayobrien\Elulacms; 

use Illuminate\Support\ServiceProvider; 

class ElulacmsServiceProvider extends ServiceProvider{
    
    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/../routes/elulacms.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'elulacms');
    }

    public function register(){
    }
}