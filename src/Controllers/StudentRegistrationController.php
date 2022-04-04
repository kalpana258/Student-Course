<?php

namespace src\Controllers;

use src\Model\Student;
use src\core\Views;
use src\core\CustomException;
use src\core\Validator;
use src\Helper;

class StudentRegistrationController
{
    
    public function __construct()
    {
        $this->validator = new Validator();
        $this->student = new Student();
    }
 
    /**
     * This method load view for student create
     *
     *
     */
    public function showStudentForm()
    {
        try {
            $view = new Views('studentReg/index.php');
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
    /**
     * This method create student
     *
     *
     */
    public function createStudent()
    {
        try {
          $helper = new Helper();
         $countryCodes = $helper->getCountryCodes();
         
         if (isset($_POST['submit'])) {
             $this->validate($_POST);
             if(!empty($this->validator->getErrors())){
                    $view = new Views('studentReg/index.php');
                    $view->assign('errors',$this->validator->getErrors());
                     $view->assign('postData',$_POST);
                     $view->assign('countryCodes',$countryCodes);
                    return;
             }else{
                $_POST['fname'] = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
                $_POST['lname'] = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
                $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              
                $save = $this->student->add($_POST);
                if ($save) {
                     $view = new Views('studentReg/index.php');
                    $view->assign('success', 'Data saved successfully.');
                     $view->assign('countryCodes',$countryCodes);
                    return;
                } else {
                    $view = new Views('studentReg/index.php');
                    $view->assign('errors', 'There is issue in saving the data in Database. Please try again.');
                    $view->assign('postData',$_POST);
                    $view->assign('countryCodes',$countryCodes);
                    return ;
                }
             }
          
         }
           $view = new Views('studentReg/index.php');
            $view->assign('countryCodes',$countryCodes);
           return;
        
        } catch (CustomException $e) {
           
            echo   $e->customFunction($e);
          
        }
    }
    /**
     * This method list the students
     *
     *
     */
    public function list()
    {
        try {
            $view = new Views('studentReg/view.php');
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
    /**
     * This method delete the student
     *
     *
     */
    public function delete()
    {
        try {
            $id = $_POST['student_id'];
            $res = $this->student->deleteRecord($id);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
    /**
     * This method get student data by id
     *
     *
     */
    public function getStuDataByID()
    {
        try {
            $id = $_POST['id'];
            $res = $this->student->getById($id);
            echo json_encode($res);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
    /**
     * This method edit the student
     *
     *
     */
    public function edit()
    {
        try {
           // $data = $_POST;
          //   if (isset($_POST['submit'])) {
         //   var_dump($_POST);
             $this->validate($_POST);
             if(!empty($this->validator->getErrors())){
                 echo  json_encode(["success"=>false,"message"=>""]);
             }else{
                  $_POST['fname'] = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
                $_POST['lname'] = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
                $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                      $this->student->edit($_POST);
                       echo  json_encode(["success"=>true]);
             }
           
        } catch (CustomException $e) {
            echo  json_encode(["success"=>false,"message"=>"Database error occured while saving."]);
        }
    }
    
    public function validate($requestData){
         $this->validator->name('First Name')->value($requestData['fname'])
               ->pattern([
                   ['name'=>'alpha','value'=>'Alphabets',"msg"=>"Only Alphabets is allowed for First Name."],
                   ['name'=>'required','value'=>'required'],
                   ['name'=>'min','value'=>4,"msg"=>"Please enter minimum 4 chars for First Name."],
                   ['name'=>'max','value'=>50, "msg"=>"Please enter minimum 4 chars for First Name."]
                  ]);
       
          $this->validator->name('Last Name')->value($requestData['lname'])
               ->pattern([
                  ['name'=>'alpha','value'=>'Alphabets',"msg"=>"Only Alphabets is allowed for Last Name."],
                   ['name'=>'required','value'=>'required'],
                   ['name'=>'min','value'=>4,"msg"=>"Please enter minimum 4 chars for Last Name."],
                   ['name'=>'max','value'=>50,"msg"=>"Maximum 50 chars are allowed for Last Name"],
                  ]);
          
             $this->validator->name('Mobile Number')->value($requestData['contact_no'])
               ->pattern([
                   ['name'=>'mobile','value'=>'Mobile',"msg"=>"Please enter valid Mobile number."],
                   ['name'=>'required','value'=>'required'],
                   ['name'=>'min','value'=>10,"msg"=>"Please enter minimum 10 digits for Mobile No."],
                   ['name'=>'max','value'=>10,"msg"=>"Maximum 10 digits are allowed for Mobile No."],
                  ]);
             $this->validator->name('Email')->value($requestData['email'])
               ->pattern([
                   ['name'=>'email','value'=>'Email'],
                   ['name'=>'required','value'=>'required'],
                  ]);
             $this->validator->checkDate($requestData['dob']);
    }
    /**
     * This method get list of student
     *
     *
     */
    public function getList()
    {
        try {
            $records = $this->student->get($_POST);
            
            $data = array();
            $filtered_rows = count($records);
            foreach ($records as $row) {
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
            "recordsFiltered"   =>  count($this->student->get_total_all_records()),
            "data"              =>  $data
            );
            echo json_encode($output);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
}
