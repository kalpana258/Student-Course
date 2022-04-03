<?php
require 'bootstrap.php';

$statement = <<<MySQL_QUERY
   CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `details` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_code_UNIQUE` (`course_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `reg_no` varchar(45) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(45) NOT NULL,
  `is_delete` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `country_code` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_UNIQUE` (`phone`),
  UNIQUE KEY `reg_no_UNIQUE` (`reg_no`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE `student_course_mapping` (
  `reg_no` varchar(45) NOT NULL,
  `course_code` varchar(45) NOT NULL,
  UNIQUE KEY `unique_key_map` (`reg_no`,`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
   
MySQL_QUERY;

try {
	
    $createTable = $conn->exec($statement);
	
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}