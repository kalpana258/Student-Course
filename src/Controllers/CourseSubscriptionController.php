<?php

namespace src\Controllers;

use src\Model\Student;
use src\core\Views;
use src\Model\Course;
use src\Model\StudentCourseMapping; 
use src\core\CustomException;

class CourseSubscriptionController {
    
    public function __construct(){
         
    }
    public function loadForm(){
        try{
        $studentDropdown = Student::get_total_all_records();
          $courseDropdown = Course::get_total_all_records();
        $view = new Views('studentCourseMap/studentSubscription.php');
         $view->assign('studentdropdown', $studentDropdown);
          $view->assign('courseDropdown', $courseDropdown);
           }catch(CustomException $e){
               
           echo   $e->customFunction();
         }
    }
    
     public function storeSubscription(){
      try{
       if(isset($_POST) && !empty($_POST)){
             $requestData = $_POST;
//             echo "<pre>";
//             print_r($requestData);
//             echo "</pre>";
//             exit();
            StudentCourseMapping::storeStudentCourseMapping($requestData); 
            header('Location: /report');
       }
        }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
    
      public function getStudentCourseSubscription(){
      
      try{
        $response = StudentCourseMapping::getStudentCourseMapping(); 
         $view = new Views('studentCourseMap/report.php');
         $view->assign('response', $response);
          }catch(CustomException $e){
           echo   $e->customFunction();
         }
       
    }
   
       
    
}

