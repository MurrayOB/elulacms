<?php

namespace Murrayobrien\Elulacms\Http\Controllers;

use Illuminate\Http\Request;

class ElulacmsCollectionController extends Controller {

    //post
    public function addCollection(Request $request){
        return 'Data sent'; 
    }

    //get
    public function getCollection(){
        return 'All Collections'; 
    }
}