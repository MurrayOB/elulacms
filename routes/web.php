<?php

Route::get('/cms', function () {
    return redirect('/cms/dashboard');
});

Route::get('/cms/login', function(){
    return view('elulacms::auth/login'); 
}); 

Route::get('/cms/dashboard', function(){
    return view('elulacms::dashboard'); 
}); 
