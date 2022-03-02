<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint; 

use Murrayobrien\Elulacms\Helpers\CollectionHelper; 

class ElulacmsCollectionController extends Controller {

    /**
     * Ideas :
     *      1. Create a table called elulacms_collectionName
     *      2. Create a model called 
     */

    //post
    public function addCollection(Request $request){
        //Validation
        // $request->validate([
        //     'collectionName' => 'required|string|max:255'
        // ]); 

        $collectionName = $request->collectionName;
        $fieldTypes = $request->fieldTypes; 

        Schema::create('elulacms_'.$collectionName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        //Artisan::call('migrate');
    }

    //get
    /**
     * call a function that returns the data so that it can be used in both this api controller and 
     * from a return View(data...) etc. 
     */
    public function getCollection(){
        return 'All Collections'; 
    }

    public function getCollectionDataByName($collectionName){
        $name = 'elulacms_'.$collectionName; 
        //Search DB for table data
    }
}