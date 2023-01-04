<?php

namespace MemberWebServices;

class Error{

    private $errorCode;
    private $errorMessage;

    public function __construct($errors)
    {
        $this->errorCode = $errors->errorCode;
        $this->errorMessage = $errors->errorMessage;    
    }

    public function getError(){
        return $this->errorCode . " " . $this->errorMessage;
    }
}








?>