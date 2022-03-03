<?php

namespace Murrayobrien\Elulacms\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint; 

class CollectionHelper {

    function createCollection(string $collectionName, $fieldArray){
        $tableName = 'elulacms_'.strtolower($collectionName); 

        if (Schema::hasTable($tableName))
        {
            return response()->json([
                'message' => 'Collection name already exists'
            ]); 
        }

        //Add to DB
        Schema::create($tableName, function (Blueprint $table) use ($fieldArray) {
            $table->increments('id');
            //Dynamically Add Values
            foreach($fieldArray as $value){
                $this->getTableType($table, $value); 
            }
            $table->timestamps();
        });
 
        //Add to collections records
        DB::table('elula_collections')->insert([
            'collection_name' => $tableName
        ]);

        //Artisan::call('make:model', ['name' => 'test']); 
        return response()->json([
            'message' => 'Successfully created collection'
        ]); 
    }

    
    function getAllCollections(){
        $collections = DB::table('elula_collections')
                        ->select('collection_name')
                        ->get(); 
        
        $newCollectionsArray = array(); 
        foreach($collections as $value){
            array_push($newCollectionsArray, substr($value->collection_name, 9)); 
        }

        return response()->json([
            'collections' => $newCollectionsArray
        ]); 
    }
    
    function getCollectionDataByName(string $collectionName){
        
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