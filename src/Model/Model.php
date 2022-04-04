<?php

namespace src\Model;

use src\core\DatabaseConnector;


class Model{
    
    public function __construct() {
        $this->dbInstance = DatabaseConnector::getInstance();
        $this->conn = $this->dbInstance->getConnection();
    }
    
    public function insert($tableName,$fieldList,$bindArray,$mapList){
        $stmt = $this->conn->prepare("INSERT INTO ".$tableName."(".$fieldList.") VALUES(".$mapList.")");
        foreach($bindArray as $key=>$bindParams){
             $stmt->bindValue($key,$bindParams);
        }
        $stmt->execute();
    }
    
    
     public function update($tableName,$setClause,$bindArray,$whereClause){
        $stmt = $this->conn->prepare("UPDATE ".$tableName." SET ".$setClause." WHERE ".$whereClause."");
       foreach($bindArray as $key=>$bindParams){
             $stmt->bindValue($key,$bindParams);
        }
        $stmt->execute();
    }
    
      public  function delete($tablename,$setClause,$bindArray,$whereClause)
    {
            $statement = $this->conn->prepare("UPDATE ".$tablename." SET ".$setClause." WHERE ".$whereClause."");
           foreach($bindArray as $key=>$bindParams){
             $statement->bindValue($key,$bindParams);
           }
            $statement->execute();
           
    }
    
     public  function readById($tablename,$bindArray,$whereClause)
     {
         $query = "SELECT * FROM ".$tablename." WHERE ".$whereClause." LIMIT 1";
         
           $stmt = $this->conn->prepare($query);
            $stmt->execute($bindArray);
         return $stmt;
     }
     
      public  function readAll($tablename,$whereClause,$request)
     {
         $query = "SELECT * FROM ".$tablename." WHERE ".$whereClause."";
                           if (isset($request["length"]) && $request["length"] != -1) {
                $query .= ' LIMIT ' .$request['start']. ', ' .$request['length'];
            }
           
           $stmt = $this->conn->prepare($query);
            $stmt->execute();
         return $stmt;
     }
}

