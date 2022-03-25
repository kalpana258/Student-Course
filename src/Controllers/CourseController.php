<?php

namespace src\Controllers;

use src\Model\Course;
use src\core\Views;
use src\core\CustomException;

class CourseController{
    
    public function __construct(){
        
    }
    
    public function showCourseForm(){
        try{
           $view = new Views('course/index.php');
        }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
    
    public function createCourse(){
         try{
            if(isset($_POST) && !empty($_POST)){
            $save = Course::add($_POST);
             if($save){
                   header('Location: /courseList');

             }
             else
             {
                 $view = new Views('course/index.php');
                 $view->assign('errors', 'Something went wrong');
             }
            }else{
                 $view = new Views('course/index.php');
                 $view->assign('errors', 'Something went wrong');
            }
         }catch(CustomException $e){
           echo   $e->customFunction();
         }
           
    }
    
     public function list(){
         try{
       $view = new Views('course/view.php');
       }catch(CustomException $e){
           echo   $e->customFunction();
         }

    }
    public function delete(){
        try{
        $id = $_POST['course_id'];
        $res = Course::delete($id);
        }catch(CustomException $e){
           echo   $e->customFunction();
         }
         
    }
    
     public function getCourseById(){
       try{
        $id = $_POST['id'];
        $res = Course::getById($id);
        echo json_encode($res);
        }catch(CustomException $e){
           echo   $e->customFunction();
         }
         
    }
    
      public function edit(){
     try{
       $data = $_POST;   
       Course::edit($data);
       echo json_encode(["success"=>True]);
     }catch(CustomException $e){
           echo json_encode(["success"=>False]);
         }
         
    }
     public function getList(){
           try{
            $records = Course::get($_POST);
            
            $data = array();
$filtered_rows = count($records);
foreach($records as $row)
{
    $sub_array = array();
   $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-primary btn-sm update">Edit</button>';
    $sub_array[] = $row["name"];
    $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-sm delete">Delete</button>';
    $data[] = $sub_array;
}
$output = array(
    "draw"              =>  intval($_POST["draw"]),
    "recordsTotal"      =>  $filtered_rows,
    "recordsFiltered"   =>   count(Course::get_total_all_records()),
    "data"              =>  $data
);
echo json_encode($output);
       }catch(CustomException $e){
           echo   $e->customFunction();
         }
    }
}
