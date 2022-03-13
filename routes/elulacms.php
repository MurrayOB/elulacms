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
    return view('elulacms::auth/login')->with('cmsname', config('elulacms.cms.name')); 
}); 

Route::get('/cms/dashboard', function(){
    return view('elulacms::dashboard'); 
});

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
// TO DO
Route::post('/cms/deleteEntry', [ElulacmsCollectionController::class, 'deleteEntry']); 
Route::post('/cms/publishStatus', [ElulacmsCollectionController::class, 'publishStatus']); 
Route::post('/cms/updateEntry', [ElulacmsCollectionController::class, 'updateEntry']); 



