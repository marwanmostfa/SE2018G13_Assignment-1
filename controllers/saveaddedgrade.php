<?php

include_once("../controllers/common.php");
include_once("../models/grade.php");
Database::connect('school', 'root', '');
$id = safeGet("id");
$course_id = safeGet("courseID");
$degree = safeGet("degree");
$examine_at = safeGet("examine_at");

Grade::add($course_id, $id, $degree, $examine_at);

header('Location: ../students.php');
?>