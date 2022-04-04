<?php
namespace src\Model;

use src\core\CustomException;
use src\Model\Model;

class Student extends Model
{
     public function __construct(){
		parent::__construct();
             
	}

    public function edit($data)
    {
        try {
              
               $statement = $this->conn->prepare("UPDATE student SET _at WHERE id = :id");
              
               $bindArray=    array(
                       ':fname'   =>  $data["fname"],
                       ':lname' =>  $data["lname"],
                       ':dob'       =>  $data["dob"],
                       ':phone'       =>  $data["phone"],
                       ':country_code'       =>  $data["countryCode"],
                       ':email'       =>  $data["email"],
                       ':updated_at'       =>  date('Y-m-d H:i:s'),
                        ':id'=> $data["student_id"]
                    );
               $setClause = "fname = :fname, lname = :lname, dob = :dob,phone = :phone,:email=:email,country_code=:country_code,updated_at=:updated";
               $whereClause = "id = :id";
               $this->update("student",$setClause,$bindArray,$whereClause);
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }

    public  function get_total_all_records()
    {
        try {
//            $statement = $this->conn->prepare("SELECT * FROM student where is_delete=0");
//            $statement->execute();
//            $result = $statement->fetchAll();
//            return $result;
//            
              $whereClause= "is_delete=0";
           // $stmt->execute();
               $response =$this->readAll('student', $whereClause,[]);
            $response = $response->fetchAll();
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function get($request)
    {
        try {
//            $query ="SELECT * FROM student where is_delete=0";
//            if ($request["length"] != -1) {
//                $query .= ' LIMIT ' .$request['start']. ', ' .$request['length'];
//            }
//            $stmt =  $this->conn->query($query);
           $whereClause= "is_delete=0";
           // $stmt->execute();
               $response =$this->readAll('student', $whereClause,$request);
            $response = $response->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function getByID($id)
    {
        try {
             $whereClause = "id =:id AND is_delete=0";
             $bindArray = array(
                ':id'       =>  $id
                );
         
            $response =$this->readById('student',$bindArray, $whereClause,true);
              $response = $response->fetch(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function deleteRecord($id)
    {
        try {
           
             $bindArray =   array(
                ':delete'   =>  1,
                ':id'       =>  $id
                );
             $setClause = "is_delete = :delete";
             $whereClause = "id = :id";
             $this->delete('student', $setClause, $bindArray, $whereClause);
        } catch (\Exception $exception) {
            var_dump($exception);
             throw new CustomException($exception->getMessage());
        }
    }
    
    public function add($data)
    {
        try {
            $stuRegNo = str_pad(mt_rand(1,999999),6,'0',STR_PAD_LEFT);
            $bindArray = array(
                       ':fname'   =>  $data["fname"],
                       ':lname' =>  $data["lname"],
                       ':regno'       =>  $stuRegNo,
                       ':dob'       =>  date("Y-m-d", strtotime($data['dob'])),
                       ':phone'       =>  $data["contact_no"],
                       ':country_code'       =>  $data["countryCode"],
                       ':email'       =>  $data["email"],
                       ':created_at'       =>  date('Y-m-d H:i:s'),
                       ':updated_at'       =>  date('Y-m-d H:i:s'),
                       
                    );
                $fieldList = '`fname`, `lname`,`reg_no`, `dob`,`phone`,`email`,`country_code`,`created_at`,`updated_at`';  
               $valueList =  ":fname,:lname,:regno,:dob,:phone,:email,:country_code,:created_at,:updated_at";
                $this->insert('student',$fieldList,$bindArray,$valueList);
      
            return true;
        } catch (\Exception $exception) {
            
             if($exception instanceof \PDOException) {
                 throw new CustomException("Database error occured while saving.");
             }else{
                   throw new CustomException("There is some error while saving");
             }
             
        }
    }
}
