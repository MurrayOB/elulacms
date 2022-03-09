<?php

namespace Murrayobrien\Elulacms\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint; 

//This class is intended to be used by
//1. The front-end of the Cms 
//2. The CMS api controller

class CollectionHelper {

    function createCollection(string $collectionName, $fieldArray){
        $tableName = 'elulacms_'.strtolower($collectionName); 

        if (Schema::hasTable($tableName))
        {
            return response()->json([
                'message' => 'Collection name already exists'
            ]); 
        }

        //Create collection table
        Schema::create($tableName, function (Blueprint $table) use ($fieldArray) {
            $table->increments('id');
            //Dynamically Add Values
            foreach($fieldArray as $value){
                $this->getTableType($table, $value); 
            }
            $table->timestamps();
        });
 
        //Store Collection name
        $collectionID = DB::table('elula_collections')->insertGetId([
            'collection_name' => $tableName
        ]);

        //Store collection fields
        $newArray = array(); 
        foreach($fieldArray as $value){
            array_push($newArray, ['name' => $value['title'], 'type' => $value['id'], 'collection_id' => $collectionID]); 
        }
        DB::table('elula_collections_fields')->insert($newArray); 

        //Artisan::call('make:model', ['name' => 'test']); 
        return response()->json([
            'message' => 'Successfully created collection'
        ]); 
    }

    function getAllCollections(){
        //Get Collections Names
        $collectionNames = DB::table('elula_collections')
                        ->select('id','collection_name')
                        ->get(); 
        // Get Collections Fields from elula_collections_fields
        $collections = array(); 
        foreach($collectionNames as $value){
            $fields = DB::table('elula_collections_fields')
                        ->select('name','type')
                        ->where('collection_id', $value->id) 
                        ->get(); 
            $data = DB::table($value->collection_name)
                        ->get(); 
            array_push($collections, ['id' => $value->id, 'name' => substr($value->collection_name, 9), 'fields' => $fields, 'data' => $data]); 
        }
        return $collections; 
    }
    
    //Have an option
    //For api calls
    //Or get Model calls
    //localhost:8000/getCollectionDataByName=?ids&?columnsOnly
    function getCollectionDataByName(string $collectionName){
        
    }

    function deleteCollectionById($id){
        $tableName = DB::table('elula_collections')->select('collection_name')->where('id', $id)->first(); 
        DB::table('elula_collections')->where('id', $id)->delete(); 
        Schema::drop($tableName->collection_name); 
        return true; 
    }

    private function getTableType(Blueprint $table, $value){
        $lowerCaseVal = strtolower($value['title']); 
        switch($value['id']){
            case 1:
                return $table->string($lowerCaseVal); 
                break;
            case 2:
                return $table->longText($lowerCaseVal); 
                break;
            case 3:
                return $table->integer($lowerCaseVal); 
                break;
            case 4:
                return $table->string($lowerCaseVal); 
                break;
            case 5:
                return $table->date($lowerCaseVal); 
                break;
            case 6:
                return $table->boolean($lowerCaseVal); 
                break;
        }
    }
}