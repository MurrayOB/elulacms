<?php

use Illuminate\Support\Facades\Route;
use Murrayobrien\Elulacms\Http\Controllers\ElulacmsCollectionController;

/**
 * Web Routes
 */
Route::get('/cms', function () {
    return redirect('/cms/dashboard');
});

Route::get('/cms/login', function(){
    return view('elulacms::auth/login'); 
}); 

Route::get('/cms/dashboard', function(){
    return view('elulacms::dashboard'); 
});

/**
 * API Routes
 */
Route::post('/cms/addCollection', [ElulacmsCollectionController::class, 'addCollection']); 
Route::get('/cms/getCollections', [ElulacmsCollectionController::class, 'getCollections']); 

