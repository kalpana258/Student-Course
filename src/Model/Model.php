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
           $row = 0;
//        $rowperpage = 2;
//        
            if(isset($request['num_rows'])){
                $rowperpage = $request['num_rows'];
            }
            // Previous Button
            if(isset($request['but_prev'])){
                $row = $request['row'];
                $row -= $rowperpage;
                if( $row < 0 ){
                    $row = 0;
                }
            }
             // Next Button
            if(isset($request['but_next'])){
                $row = $request['row'];
                $allcount = $request['allcount'];

                $val = $row + $rowperpage;
                if( $val < $allcount ){
                    $row = $val;
                }
            }
            

         $query = "SELECT * FROM ".$tablename." WHERE ".$whereClause."";
                    if(!empty($request)){  
                        
                $query .= ' LIMIT ' .$row. ', ' .$rowperpage;
                    }

                
           
           $stmt = $this->conn->prepare($query);
           $stmt->execute();
           
         return $stmt;
     }
}

