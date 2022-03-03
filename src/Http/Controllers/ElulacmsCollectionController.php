<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;

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

        //Add collection from Helper class
        $collectionHelper = new CollectionHelper(); 
        $collectionHelper->createCollection($collectionName, $fieldTypes); 
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