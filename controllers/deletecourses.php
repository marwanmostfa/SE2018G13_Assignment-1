<?php

header('Content-Type: application/json; charset=utf-8');
include_once("../models/Courses.php");
Database::DBConnect();
$courses = new Courses($_GET['id']);
$courses->delete();
echo json_encode(['status' => 1]);
?>
