<?php
namespace src\Model;

use src\core\DatabaseConnector;
use src\core\CustomException;

class Student
{
    
    public static function edit($data)
    {
        try {
               $dbInstance = DatabaseConnector::getInstance();
               $conn = $dbInstance->getConnection();
               $statement = $conn->prepare("UPDATE student SET fname = :fname, lname = :lname, dob = :dob,phone = :phone,updated_at=:updated_at WHERE id = :id");
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

    public static function get_total_all_records()
    {
        try {
             $dbInstance = DatabaseConnector::getInstance();
               $conn = $dbInstance->getConnection();

            $statement = $conn ->prepare("SELECT * FROM student where is_delete=0");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public static function get($request)
    {
        try {
            $query ="SELECT * FROM student where is_delete=0";
            if ($request["length"] != -1) {
                $query .= ' LIMIT ' .$request['start']. ', ' .$request['length'];
            }
            $dbInstance = DatabaseConnector::getInstance();
            $conn = $dbInstance->getConnection();
            $stmt = $conn->query($query);
            $stmt->execute();
            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public static function getByID($id)
    {
        try {
            $dbInstance = DatabaseConnector::getInstance();
            $conn = $dbInstance->getConnection();
            $stmt = $conn->prepare("SELECT * FROM student WHERE id =:id AND is_delete=0 LIMIT 1");
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
    public static function delete($id)
    {
        try {
            $dbInstance = DatabaseConnector::getInstance();
            $conn = $dbInstance->getConnection();
            $statement = $conn->prepare("UPDATE student SET is_delete = :delete WHERE id = :id");
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
    
    public static function add($data)
    {
        try {
            $dbInstance = DatabaseConnector::getInstance();
            $conn = $dbInstance->getConnection();
   //      $conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
//$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
            $stmt = $conn->prepare("INSERT INTO student(`fname`, `lname`, `dob`,`phone`,`created_at`,`updated_at`) VALUES(:fname,:lname,:dob,:phone,:created_at,:updated_at)");
            $stmt->bindValue(':fname', $data['fname']??null);
            $stmt->bindValue(':lname', $data['lname']??null);
//$stmt->bindValue(':dob',  date($data['dob'],"Y-m-d")??NULL);
            $stmt->bindValue(':dob', date("Y-m-d", strtotime($data['dob']))??null);
            $stmt->bindValue(':phone', $data['contact_no']??null);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
            $stmt->execute();
            return true;
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
}
