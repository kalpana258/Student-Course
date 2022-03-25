<?php

namespace src\core;

use Exception;
class CustomException extends Exception{
   // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Throwable $previous = null) {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction() {
       // $filename = "error".date('d-m-y').".log";
       // error_log(date('d-m-y h:i:s')." ". $this->__toString(),"","/public/".$filename);
       
        $view = new Views('error/error.php');
       
    }
}