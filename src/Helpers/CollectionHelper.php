<?php

namespace Murrayobrien\Elulacms\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint; 

class CollectionHelper {
    //Artisan::call('migrate');

    //Field Types: 
    // id: 1. text -> string()
    // id: 2. rich text -> longText()
    // id: 3. number -> integer()
    // id: 4. image -> string('') (file path is saved)
    // id: 5. date -> date('')
    // id: 6. boolean -> boolean()
    function createCollection(string $collectionName, $fieldArray){
        if (Schema::hasTable('elulacms_'.strtolower($collectionName)))
        {
            return response('Collection name already exists', 200); 
        }

        //Add to DB
        Schema::create('elulacms_'.strtolower($collectionName), function (Blueprint $table) use ($fieldArray) {
            $table->increments('id');
            //Dynamically Add Values
            foreach($fieldArray as $value){
                $this->getTableType($table, $value); 
            }
            $table->timestamps();
        });
    }

    private function getTableType(Blueprint $table, $value){
        $lowerCaseVal = strtolower($value['title']); 

        switch($value){
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
            default: 
                return null;
        }

        
    }

    function getAllCollections(){

    }

    function getCollectionByName(){
        
    }
}