<?php

include_once("../controllers/common.php");
include_once("../models/Courses.php");

Database::DBConnect();
$id = safeGet("id", 0);
if ($id == 0) {
    Courses::add(safeGet("name"), safeGet("study_year"), safeGet("max_degree"));
} else {
    $courses = new Courses($id);
    $courses->name = safeGet("name");
    $courses->study_year = safeGet("study_year");
    $courses->max_degree = safeGet("max_degree");
    $courses->save();
}
header('Location: ../courses.php');
?>