<?php

namespace src\core;


//a db class for connecting to the database
class DatabaseConnector{
      
    private static $instance = NULL;
    private $conn;
    
   private function __construct()
  {

    $this->conn = new \PDO("mysql:host={$_ENV["DB_HOST"]};
    dbname={$_ENV["DB_DATABASE"]}",$_ENV["DB_USERNAME"],$_ENV["DB_PASSWORD"],
    array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ));
    $this->conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }
    public static function getInstance() {
       try{
      if (!isset(self::$instance)) {
       
        self::$instance = new DatabaseConnector();
      }
      
      return self::$instance;
       }catch(\Exception $e){
            $ex = new CustomException("error");
         echo $ex->customFunction();
       }
    }
    
    public function getConnection()
  {
    return $this->conn;
  }
  
  public function closeConnection()
  {
    $this->conn==null;
  }
    
    
  }

?>