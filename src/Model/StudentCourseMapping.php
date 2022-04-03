<?php

namespace src\Model;

use src\core\DatabaseConnector;
use src\core\CustomException;

class StudentCourseMapping
{
    
    
    public static function storeStudentCourseMapping($request)
    {

        try {
                $dbInstance = DatabaseConnector::getInstance();
                $conn = $dbInstance->getConnection();
                $stmt = $conn->prepare("INSERT INTO student_course_mapping(`reg_no`, `course_code`) VALUES(:student,:course)");

            for ($i=0; $i<count($request['student']); $i++) {
                $stmt->bindValue(':student', $request['student'][$i]);
                $stmt->bindValue(':course', $request['course'][$i]);
                $stmt->execute();
            }

               return true;
        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
    
    public static function getStudentCourseMapping()
    {
        
        try {
              $dbInstance = DatabaseConnector::getInstance();
              $conn = $dbInstance->getConnection();
       
               $statement = $conn ->prepare("SELECT student.fname,course.name FROM student_course_mapping as mapping inner join"
                . " student on mapping.reg_no = student.reg_no"
                . " inner join course on  mapping.course_code = course.course_code"
                . " where student.is_delete=0 and course.is_delete=0");
        
                $statement->execute();
                $result = $statement->fetchAll();
    
                return $result;
        } catch (\Exception $exception) {
             throw new CustomException($exception->getMessage());
        }
    }
}
