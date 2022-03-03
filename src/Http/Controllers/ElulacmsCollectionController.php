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
        $request->validate([
            'collectionName' => 'required|string|max:255', 
        ]); 

        $collectionName = $request->collectionName;
        $fieldTypes = $request->fieldTypes; 

        //Add collection from Helper class
        $collectionHelper = new CollectionHelper(); 
        return $collectionHelper->createCollection($collectionName, $fieldTypes); 
    }

    //get
    public function getCollections(){
        $collectionHelper = new CollectionHelper(); 
        return $collectionHelper->getAllCollections(); 
    }

    public function getCollectionDataByName($collectionName){
        $name = 'elulacms_'.$collectionName; 
        //Search DB for table data
    }
}