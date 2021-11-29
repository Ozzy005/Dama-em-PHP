<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Core;

class Father{

    protected $data;

    public function __construct(){
        $this->data = Data::getInstance();
    }
}