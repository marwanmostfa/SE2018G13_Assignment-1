<?php

header('Content-Type: application/json; charset=utf-8');
include_once("../models/student.php");
Database::DBConnect();
$student = Student::all($_GET['keyword'], $_GET['column'], $_GET['order']);

echo json_encode($student);
?>
