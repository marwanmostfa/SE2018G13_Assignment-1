<?php

header('Content-Type: application/json; charset=utf-8');
include_once("../models/grade.php");
Database::DBConnect();
$page = $_GET['page'];

if ($page == "std") {
    $grades = Grade::std_all($_GET['ID'], $_GET['column'], $_GET['order']);
} else if ($page == "crs") {
    $grades = Grade::crs_all($_GET['ID'], $_GET['column'], $_GET['order']);
}

echo json_encode($grades);
?>