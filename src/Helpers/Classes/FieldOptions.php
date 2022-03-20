<?php

namespace Murrayobrien\Elulacms\Helpers\Classes;

class FieldOptions {
    public $nullable;
    
    function __construct($nullable = false){
        $this->nullable = $nullable; 
    }
}