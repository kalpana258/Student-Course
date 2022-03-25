<?php
require_once 'bootstrap.php'; 
 require_once('routes.php');
 
use src\Controllers\StudentRegistrationController;
use src\Controllers\CourseController;
use src\Controllers\CourseSubscriptionController;

error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

ini_set('ignore_repeated_errors', TRUE); // always use TRUE

//ini_set('display_errors', FALSE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment

ini_set('log_errors', TRUE); // Error/Exception file logging engine.

route('/', function () {
   
         $controller = new StudentRegistrationController();     
        $controller->list();
});

route('/createStudent', function () {
    $controller = new StudentRegistrationController();     
        $controller->createStudent(); 
});
route('/loadForm', function () {
   $controller = new StudentRegistrationController();     
        $controller->showStudentForm(); 
        
});
route('/getlist', function () {
    $controller = new StudentRegistrationController();     
        $controller->getlist();
});

route('/delete', function () {
    $controller = new StudentRegistrationController();     
        $controller->delete();
});
route('/getstudent', function () {
    $controller = new StudentRegistrationController();     
        $controller->getStuDataByID();
});
route('/edit', function () {
    $controller = new StudentRegistrationController();     
        $controller->edit();
});

route('/course', function () {
    $controller = new CourseController();     
        $controller->showCourseForm();
});
route('/createCourse', function () {
    $controller = new CourseController();     
        $controller->createCourse(); 
});
route('/courseList', function () {
    $controller = new CourseController();     
        $controller->list();
});
route('/getCourseList', function () {
    $controller = new CourseController();     
        $controller->getlist();
});

route('/deleteCourse', function () {
    $controller = new CourseController();     
        $controller->delete();
});
route('/getCourse', function () {
    $controller = new CourseController();     
        $controller->getCourseById();
});
route('/editCourse', function () {
    $controller = new CourseController();     
        $controller->edit();
});

// routes for student course subscription
route('/studentCourseMap', function () {
    $controller = new CourseSubscriptionController();     
        $controller->loadForm();
});

route('/saveStudentSuscription', function () {
    $controller = new CourseSubscriptionController();     
        $controller->storeSubscription();
});
route('/report', function () {
    $controller = new CourseSubscriptionController();     
        $controller->getStudentCourseSubscription();
});

$action = $_SERVER['REQUEST_URI'];

dispatch($action);
