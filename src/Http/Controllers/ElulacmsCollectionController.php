<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;

class ElulacmsCollectionController extends Controller {

    //post
    public function addCollection(Request $request){
        $request->validate([
            'collectionName' => 'required|string|max:255'
        ]); 

        $collectionName = $request->collectionName;
        $fieldTypes = $request->fieldTypes; 

        dd($fieldTypes); 
        
        return "good"; 
    }

    //get
    public function getCollection(){
        return 'All Collections'; 
    }
}