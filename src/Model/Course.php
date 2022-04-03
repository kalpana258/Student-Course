<?php
namespace src\Model;

use src\core\CustomException;
use src\Model\Model;

class Course extends Model
{
    public function __construct(){
		parent::__construct();
             
	}
    public  function edit($data)
    {
        try {
            $statement = $this->conn->prepare("UPDATE course SET name = :name, details = :details,updated_at=:updated_at WHERE id = :id");
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

    public  function get_total_all_records()
    {
        try {
          
       
            $statement = $this->conn ->prepare("SELECT * FROM course where is_delete=0");
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
            $query ="SELECT * FROM course where is_delete=0";
            if ($request["length"] != -1) {
                $query .= ' LIMIT ' .$request['start']. ', ' .$request['length'];
            }
            $stmt = $this->conn->prepare($query);
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
            $stmt = $this->conn->prepare("SELECT * FROM course WHERE id =:id AND is_delete=0 LIMIT 1");
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
            $statement = $this->conn->prepare("UPDATE course SET is_delete = :delete WHERE id = :id");
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
    
    public  function add($data)
    {
        try {
           
            $courseCode =str_pad(mt_rand(1,999),3,'0',STR_PAD_LEFT);
            $stmt = $this->conn->prepare("INSERT INTO course(`name`,`course_code`, `details`, `created_at`,`updated_at`) VALUES(:name,:coursecode,:details,:created_at,:updated_at)");
            $stmt->bindValue(':name', $data['courseName']??null);
            $stmt->bindValue(':details', $data['courseDetails']??null);
            $stmt->bindValue(':coursecode',$courseCode);
 
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
            $stmt->execute();
            return true;
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
}
