<?php

namespace src\Controllers;

use src\Model\Course;
use src\core\Views;
use src\core\CustomException;
use src\core\Validator;


class CourseController
{
    
    public function __construct()
    {
         $this->validator = new Validator();
         $this->course = new Course();
    }
    /**
     * This method load the view for course
     *
     * @return View
     */
    public function showCourseForm()
    {
        try {
            $view = new Views('course/index.php');
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
     /**
     * This method create the course
     *
     *
     */
    public function createCourse()
    {
        try {      
         
         if (isset($_POST['submit'])) {
          $this->validator->name('Course Name')->value($_POST['courseName'])
               ->pattern([
                   ['name'=>'required','value'=>'required'],
             
                  ]);
       
          $this->validator->name('Course Details')->value($_POST['courseDetails'])
               ->pattern([
                   ['name'=>'required','value'=>'required']
                
                  ]);
             if(!empty($this->validator->getErrors())){
                    $view = new Views('course/index.php');
                    $view->assign('errors',$this->validator->getErrors());
                     $view->assign('postData',$_POST);
                    return;
             }else{
                $_POST['courseName'] = filter_var($_POST['courseName'], FILTER_SANITIZE_STRING);
                $_POST['courseDetails'] = filter_var($_POST['courseName'], FILTER_SANITIZE_STRING);
                  $_POST['courseDetails']  = filter_var($_POST['courseDetails'], FILTER_SANITIZE_SPECIAL_CHARS);
            
                $save = $this->course->add($_POST);
                if ($save) {
                     $view = new Views('course/index.php');
                    $view->assign('success', 'Data saved successfully.');
                    return;
                } else {
                    $view = new Views('course/index.php');
                    $view->assign('errors', 'There is issue in saving the data in Database. Please try again.');
                    $view->assign('postData',$_POST);
                    return ;
                }
             }
          
         }
           $view = new Views('course/index.php');
         
           return;
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
     /**
     * This method list all the courses
     *
     *
     */
    public function list()
    {
        try {
            $view = new Views('course/newView.php');
            $view->assign('pageno',0);
            $total_pages=  count($this->course->get_total_all_records());
            $view->assign('total_pages',$total_pages);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
      /**
     * This method loads view for the list
     *
     *
     */
    public function delete()
    {
        try {
            $id = $_POST['course_id'];
            $res = $this->course->deleteRecord($id);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
      /**
     * This method get details fo selected id
     *
     *
     */
    public function getCourseById()
    {
        try {
            $id = $_POST['id'];
            $res = $this->course->getById($id);
            echo json_encode($res);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
      /**
     * This method edit the course
     *
     *
     */
    public function edit()
    {
        try {
            $data = $_POST;
           $this->course->edit($data);
            echo json_encode(["success"=>true]);
        } catch (CustomException $e) {
              echo json_encode(["success"=>false]);
        }
    }
      /**
     * This method list all the courses
     *
     *
     */
    public function getList()
    {
      
        try {
            
            $records = $this->course->get($_POST);
            
            $data = array();
            // $filtered_rows = count($records);
            // foreach ($records as $row) {
            //     $sub_array = array();
            //     // $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-primary btn-sm update">Edit</button>';
            //     $sub_array[] = $row["name"];
            //     // $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-sm delete">Delete</button>';
            //     $data[] = $sub_array;
            // }
            if(isset($_POST['but_prev']) && $_POST['but_prev']==1){
                $row = abs(intval($_POST["num_rows"]-$_POST["row"]));
            }else{
            if(isset($_POST['but_next']) && $_POST['but_next']==1 ||
                   isset($_POST['row']) ){
                $row = intval($_POST["num_rows"]+$_POST["row"]);
            }
            }
              
            $output = array(
    
           "recordsFiltered"   =>   count($this->course->get_total_all_records()),
            'row'=> isset($row)?$row:0,
            "data"              =>  $records
            );
            
          //  var_dump($data);
            echo json_encode($output);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
}
