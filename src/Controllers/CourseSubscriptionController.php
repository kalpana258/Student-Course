<?php

namespace src\Controllers;

use src\Model\Student;
use src\core\Views;
use src\Model\Course;
use src\Model\StudentCourseMapping;
use src\core\CustomException;

class CourseSubscriptionController
{
    
    public function __construct()
    {
           $this->student = new Student();
           $this->mapp = new StudentCourseMapping();
         $this->course = new Course();
    }
      /**
     * This method load form for course subscription
     *
     *
     */
    public function loadForm()
    {
        try {
            $studentDropdown = $this->student->get_total_all_records();
            $courseDropdown = $this->course->get_total_all_records();
            $view = new Views('studentCourseMap/studentSubscription.php');
            $view->assign('studentdropdown', $studentDropdown);
            $view->assign('courseDropdown', $courseDropdown);
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
      /**
     * This method save student course mapping
     *
     *
     */
    public function storeSubscription()
    {
        try {
            if (isset($_POST) && !empty($_POST)) {
                $requestData = $_POST;

                 $this->mapp->storeStudentCourseMapping($requestData);
                  header('Location: /report');
            }
        } catch (CustomException $e) {
            echo   $e->customFunction("Selected student already mapped to course.");
        }
    }
     /**
     * This method get the student course mapping
     *
     *
     */
    public function getStudentCourseSubscription()
    {
      
        try {
            $response = $this->mapp->getStudentCourseMapping();
            $view = new Views('studentCourseMap/report.php');
            $view->assign('response', $response);
        } catch (CustomException $e) {
            echo   $e->customFunction("There is some error while fetching the records");
        }
    }
}
