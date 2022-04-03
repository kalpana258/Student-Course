<?php

namespace src\Model;

use src\core\DatabaseConnector;


class Model{
    
    public function __construct() {
        $this->dbInstance = DatabaseConnector::getInstance();
        $this->conn = $this->dbInstance->getConnection();
    }
    
}

