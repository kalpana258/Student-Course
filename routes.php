<?php
 
use src\core\CustomException;
$routes = [];

/**
 * Register a new route
 *
 * @param $action string
 * @param \Closure $callback Called when current URL matches provided action
 */
function route($action, Closure $callback)
{
    global $routes;
    $action = trim($action, '/');
    $routes[$action] = $callback;
}

/**
 * Dispatch the router
 *
 * @param $action string
 */
function dispatch($action)
{
   
    try{
       
         global $routes;
    $action = trim($action, '/');
    if(!isset($routes[$action])){
            $ex = new CustomException("error");
         echo $ex->customFunction();
         exit();
    }
    $callback = $routes[$action];
    
    echo call_user_func($callback);
    }catch(\Exception $e){
        print_r($e);
        exit();
     
    }
}
?>