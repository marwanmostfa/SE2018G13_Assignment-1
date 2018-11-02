<?php

header('Content-Type: application/json; charset=utf-8');
include_once("../models/grade.php");
Database::DBConnect();
$grades = new Grade($_GET['id'] , "std");
$grades->delete();
echo json_encode(['status' => 1]);
?>
