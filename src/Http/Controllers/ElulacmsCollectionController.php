<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;

use Murrayobrien\Elulacms\Helpers\CollectionHelper; 

class ElulacmsCollectionController extends Controller {

    
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

    public function getCollections(){
        $collectionHelper = new CollectionHelper(); 
        $collections = $collectionHelper->getAllCollections(); 
        $message = 'Succcessfully fetched all collections.'; 
        return response()->json([
            'message' => $message, 
            'collections' => $collections
        ]); 
    }

    public function getCollectionDataByName($collectionName){
        $name = 'elulacms_'.$collectionName; 
        //Search DB for table data
    }

    public function deleteCollection(Request $request){
        $collectionHelper = new CollectionHelper(); 
        $response = $collectionHelper->deleteCollectionById($request->id); 
        return response()->json([
            'success' => $response
        ]); 
    }

    public function addEntry(Request $request){
        $collectionHelper = new CollectionHelper(); 
        $response = $collectionHelper->addEntry($request->collectionName, $request->formData); 
        return response()->json([
            'success' => $response
        ]); 
    }
}