<?php

namespace src\Model;

use src\core\DatabaseConnector;
use src\core\CustomException;


class StudentCourseMapping{
    
    
   public static function storeStudentCourseMapping($request) {

         try{
         $dbInstance = DatabaseConnector::getInstance();
         $conn = $dbInstance->getConnection();
         $conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
       
$stmt = $conn->prepare("INSERT INTO student_course_mapping(`student_id`, `course_id`) VALUES(:student,:course)");
//var_dump( $request['student'],$request['course']);
for($i=0;$i<count($request['student']);$i++){ 
    $stmt->bindValue(':student', $request['student'][$i]);   
    $stmt->bindValue(':course', $request['course'][$i]);
    $stmt->execute();
}
//print_r($stmt);
//exit();
 
return true;
         }  catch(\Exception $exception){
              throw new CustomException($exception->getMessage());
             
          }
    }
    
    public static function getStudentCourseMapping(){
        
        try{
              $dbInstance = DatabaseConnector::getInstance();
                $conn = $dbInstance->getConnection();
       
	$statement = $conn ->prepare("SELECT student.fname,course.name FROM student_course_mapping as mapping inner join"
                . " student on mapping.student_id = student.id"
                . " inner join course on  mapping.course_id = course.id"
                . " where student.is_delete=0 and course.is_delete=0");
        
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $result;
         }  catch(\Exception $exception){
              throw new CustomException($exception->getMessage());
             
          }
    }
}