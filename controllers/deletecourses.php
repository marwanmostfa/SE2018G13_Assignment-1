<?php
header('Content-Type: application/json; charset=utf-8');
include_once("../models/Courses.php");
Database::connect('school', 'root', '');
$courses = new Courses($_GET['id']);
$courses->delete();
echo json_encode(['status' => 1]);
?>
