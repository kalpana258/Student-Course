<?php

namespace src\Controllers;

use src\Model\Student;
use src\core\Views;
use src\Model\Course;
use src\core\CustomException;

class StudentRegistrationController{
    
    public function __construct(){
        
    }
    public function loadForm(){
        try{
        $studentDropdown = Student::get_total_all_records();
          $courseDropdown = Course::get_total_all_records();
        $view = new Views('studentReg/studentSubscription.php');
         $view->assign('studentdropdown', $studentDropdown);
          $view->assign('courseDropdown', $courseDropdown);
           }catch(CustomException $e){
              
           echo   $e->customFunction();
         }
    }
    public function showStudentForm(){
       try{
           $view = new Views('studentReg/index.php');
            }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
    
    public function createStudent(){
        try{
            if(isset($_POST) && !empty($_POST)){
            $save = Student::add($_POST);
             if($save){
                   header('Location: /');
             }  else
             {
                 $view = new Views('studentReg/index.php');
                 $view->assign('errors', 'Something went wrong');
             }
            }else{
                 $view = new Views('studentReg/index.php');
                 $view->assign('errors', 'Something went wrong');
            }
             }catch(CustomException $e){
           echo   $e->customFunction();
         }
                 
           
    }
    
     public function list(){
         try{
          $view = new Views('studentReg/view.php');
         }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
    public function delete(){
        try{
        $id = $_POST['student_id'];
        $res = Student::delete($id);
          }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
    
     public function getStuDataByID(){
       try{
        $id = $_POST['id'];
        $res = Student::getById($id);
        echo json_encode($res);
          }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
    
      public function edit(){
      try{
       $data = $_POST;   
       Student::edit($data);
        echo  json_encode(["success"=>True]);
      } catch(CustomException $e){
          echo  json_encode(["success"=>False]);
         //  echo   $e->customFunction();
           
         }
     
         
    }
     public function getList(){
             try{
            $records = Student::get($_POST);
            
            $data = array();
$filtered_rows = count($records);
foreach($records as $row)
{
    $sub_array = array();
   $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-primary btn-sm update">Edit</button>';
    $sub_array[] = $row["fname"];
    $sub_array[] = $row["lname"];
    $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-sm delete">Delete</button>';
    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>  count(Student::get_total_all_records()),
    "data"              =>  $data
);
echo json_encode($output);
             }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
}

