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
              
               $statement = $this->conn->prepare("UPDATE student SET fname = :fname, lname = :lname, dob = :dob,phone = :phone,updated_at=:updated_at WHERE id = :id");
               $result = $statement->execute(
                   array(
                       ':fname'   =>  $data["fname"],
                       ':lname' =>  $data["lname"],
                       ':dob'       =>  $data["dob"],
                       ':phone'       =>  $data["phone"],
                       ':updated_at'       =>  date('Y-m-d H:i:s'),
                        ':id'=> $data["student_id"]
                    )
               );
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }

    public  function get_total_all_records()
    {
        try {
            $statement = $this->conn->prepare("SELECT * FROM student where is_delete=0");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function get($request)
    {
        try {
            $query ="SELECT * FROM student where is_delete=0";
            if ($request["length"] != -1) {
                $query .= ' LIMIT ' .$request['start']. ', ' .$request['length'];
            }
            $stmt =  $this->conn->query($query);
            $stmt->execute();
            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function getByID($id)
    {
        try {
         
            $stmt = $this->conn->prepare("SELECT * FROM student WHERE id =:id AND is_delete=0 LIMIT 1");
            $stmt->execute(
                array(
                ':id'       =>  $id
                )
            );
            $response = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function delete($id)
    {
        try {
           
            $statement = $this->conn->prepare("UPDATE student SET is_delete = :delete WHERE id = :id");
            $result = $statement->execute(
                array(
                ':delete'   =>  1,
                ':id'       =>  $id
                )
            );
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
    
    public function add($data)
    {
        try {
            $stuRegNo = str_pad(mt_rand(1,999999),6,'0',STR_PAD_LEFT);
            $stmt = $this->conn->prepare("INSERT INTO student(`fname`, `lname`,`reg_no`, `dob`,`phone`,`email`,`country_code`,`created_at`,`updated_at`) VALUES(:fname,:lname,:regno,:dob,:phone,:email,:country_code,:created_at,:updated_at)");
            $stmt->bindValue(':fname', $data['fname']??null);
            $stmt->bindValue(':lname', $data['lname']??null);
            $stmt->bindValue(':regno', $stuRegNo??null);
            $stmt->bindValue(':email', $data['email']??null);
            $stmt->bindValue(':dob', date("Y-m-d", strtotime($data['dob']))??null);
            $stmt->bindValue(':phone', $data['contact_no']??null);
            $stmt->bindValue(':country_code', $data['countryCode']??null);
        //    $stmt->bindValue(':is_delete', 0);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
            $stmt->execute();
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
