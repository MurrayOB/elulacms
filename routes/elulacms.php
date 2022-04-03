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
    return view('elulacms::layouts.master'); 
}); 

Route::get('/cms/dashboard', function(){
    return view('elulacms::layouts.master'); 
}); 

Route::get('/cms/dashboard/{any}', function(){
    return view('elulacms::layouts.master'); 
})->where('any', '.*');

/**
 * API Routes
 */
//Collections: 
Route::post('/cms/addCollection', [ElulacmsCollectionController::class, 'addCollection']); 
Route::get('/cms/getCollections', [ElulacmsCollectionController::class, 'getCollections']); 
Route::post('/cms/deleteCollection', [ElulacmsCollectionController::class, 'deleteCollection']); 
Route::post('/cms/updateCollection', [ElulacmsCollectionController::class, 'updateCollection']);  

//Entries: 
Route::post('/cms/addEntry', [ElulacmsCollectionController::class, 'addEntry']); 
Route::post('/cms/deleteEntry', [ElulacmsCollectionController::class, 'deleteEntry']); 
Route::post('/cms/publishEntry', [ElulacmsCollectionController::class, 'publishEntry']); 
Route::post('/cms/updateEntry', [ElulacmsCollectionController::class, 'updateEntry']); 

//Media:
Route::post('/cms/uploadMedia', [ElulacmsCollectionController::class, 'uploadMedia']); 



