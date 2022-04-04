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
            $setClause ="name = :name, details =:details,updated_at=:updated";
             $whereClause = "id=:id";
             $bindingArray = array(
                ':id'=> (int)$data["course_id"],
                ':name'   =>  $data["course_name"],
                ':details' =>  $data["course_details"],
                ':updated' =>  date('Y-m-d H:i:s')
                );
           $this->update('course', $setClause, $bindingArray, $whereClause);
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }

    public  function get_total_all_records()
    {
        try {
          
            $whereClause = "is_delete=0";
            $result = $this->readAll("course", $whereClause, []);
            $response = $result->fetchAll();
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function get($request)
    {
        try {
            $whereClause = "is_delete=0";
            $result = $this->readAll("course", $whereClause, $request);
            $response = $result->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function getByID($id)
    {
        try {
          
            $bindArray= array(
                ':id'       =>  $id
                );
            $whereClause= "id =:id AND is_delete=0";
            $result = $this->readById("course", $bindArray, $whereClause);
            $response = $result->fetch(\PDO::FETCH_ASSOC);

            return $response;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    public  function deleteRecord($id)
    {
        try {
          
            $setClause = "is_delete = :delete";
            $whereClause = "id = :id";
            $bindArray=  array(
                ':delete'   =>  1,
                ':id'       =>  $id
                );
            $this->delete("course", $setClause, $bindArray, $whereClause);
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
    
    public function add($data)
    {
        try {
           
            $courseCode = str_pad(mt_rand(1,999),3,'0',STR_PAD_LEFT);
            $fieldList = "`name`,`course_code`, `details`, `created_at`,`updated_at`";
            $mapList = ":name,:coursecode,:details,:created_at,:updated_at";
            $bindArray= [
                ':name'=> $data['courseName'],
                ':details'=> $data['courseDetails'],
                ':coursecode'=> $courseCode,
                ':created_at'=>  date('Y-m-d H:i:s'),
                ':updated_at'=>  date('Y-m-d H:i:s'),
            ];
            $this->insert("course", $fieldList, $bindArray, $mapList);
            return true;
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
}
