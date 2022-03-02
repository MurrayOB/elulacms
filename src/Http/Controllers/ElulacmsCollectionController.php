<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;

class ElulacmsCollectionController extends Controller {

    public function addCollection(Request $request){
        return 'Data sent'; 
    }

    public function getCollection(){
        return 'All Collections'; 
    }
}