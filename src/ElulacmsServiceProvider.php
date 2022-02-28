<?php

namespace Murrayobrien\Elulacms; 

use Illuminate\Support\ServiceProvider; 

class ElulacmsServiceProvider extends ServiceProvider{
    
    public function boot(){
        dd('It works.'); 
    }

    public function register(){

    }
}