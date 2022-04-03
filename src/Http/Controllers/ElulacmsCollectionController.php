<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;

use Murrayobrien\Elulacms\Helpers\CollectionHelper; 

class ElulacmsCollectionController extends Controller {

    //Media
    public function uploadMedia(Request $request){
        //validate image
        // $request->validate([
        //     'files' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        // ]);
         
        $collectionHelper = new CollectionHelper(); 
        return $collectionHelper->uploadMedia($request->files);
    }

    //Collections
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

    public function updateCollection(Request $request){
        $collectionHelper = new CollectionHelper(); 
        $response = $collectionHelper->updateCollection(
            $request->collectionID, 
            $request->originalCollectionName, 
            $request->updatedCollectionName, 
            $request->updatedCollection, 
            $request->removedItems
        ); 

        return response()->json([
            'success' => $response
        ]); 
    }

    //Entries
    public function addEntry(Request $request){
        $collectionHelper = new CollectionHelper(); 
        $response = $collectionHelper->addEntry($request->collectionName, $request->formData); 
        return response()->json([
            'success' => $response
        ]); 
    }

    public function deleteEntry(Request $request){
        $collectionHelper = new CollectionHelper();
        $response = $collectionHelper->deleteEntry($request->id, $request->collectionName); 
        return response()->json([
            'success' => $response
        ]); 
    }

    public function publishEntry(Request $request){
        $collectionHelper = new CollectionHelper();
        $response = $collectionHelper->publishEntry($request->id, $request->collectionName); 
        return response()->json([
            'success' => $response
        ]); 
    }

    public function updateEntry(Request $request){
        $collectionHelper = new CollectionHelper();
        $response = $collectionHelper->updateEntry($request->id, $request->collectionName, $request->entry); 
        return response()->json([
            'success' => $response
        ]); 
    }
}