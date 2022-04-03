<?php

namespace src\core;

use Exception;

class CustomException extends Exception
{
   // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString()
    {
       // return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        return " {$this->message}\n";
    }

    public function customFunction($errorMessage="")
    {
       echo   __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        $view = new Views('error/error.php');
         $view->assign('errorMessage',$errorMessage);
    }
}
