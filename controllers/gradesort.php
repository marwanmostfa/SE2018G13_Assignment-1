<?php

header('Content-Type: application/json; charset=utf-8');
include_once("../models/grade.php");
Database::connect('school', 'root', '');
$page = $_GET['page'];

if ($page == "std") {
    $student = Student::all($_GET['keyword'], $_GET['column'], $_GET['order']);
}
echo json_encode($student);
?>