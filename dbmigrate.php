<?php
require 'bootstrap.php';

$statement = <<<MySQL_QUERY
    CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_UNIQUE` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `details` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_delete` int(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
        
CREATE TABLE `student_course_mapping` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  UNIQUE KEY `student_id` (`student_id`,`course_id`),
  KEY `courseid_idx` (`course_id`),
  KEY `studentid_idx` (`student_id`),
  CONSTRAINT `courseid` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `studentid` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


   
MySQL_QUERY;

try {
	
    $createTable = $conn->exec($statement);
	
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}