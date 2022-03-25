<?php
namespace src\Model;

use src\core\DatabaseConnector;
use src\core\CustomException;

class Course
{
    
    public static function edit($data)
    {
        try {
            $dbInstance = DatabaseConnector::getInstance();
            $conn = $dbInstance->getConnection();
            $statement = $conn->prepare("UPDATE course SET name = :name, details = :details,updated_at=:updated_at WHERE id = :id");
            $result = $statement->execute(
                array(
                ':name'   =>  $data["course_name"],
                ':details' =>  $data["course_details"],
                ':updated_at'       =>  date('Y-m-d H:i:s'),
                ':id'=> $data["course_id"]
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
       
            $statement = $conn ->prepare("SELECT * FROM course where is_delete=0");
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
            $query ="SELECT * FROM course where is_delete=0";
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
            $stmt = $conn->prepare("SELECT * FROM course WHERE id =:id AND is_delete=0 LIMIT 1");
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
            $statement = $conn->prepare("UPDATE course SET is_delete = :delete WHERE id = :id");
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
        
            $stmt = $conn->prepare("INSERT INTO course(`name`, `details`, `created_at`,`updated_at`) VALUES(:name,:details,:created_at,:updated_at)");
            $stmt->bindValue(':name', $data['courseName']??null);
            $stmt->bindValue(':details', $data['courseDetails']??null);

            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
            $stmt->execute();
            return true;
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
}
