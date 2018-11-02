<?php

include_once("../controllers/common.php");
include_once("../models/grade.php");
Database::DBConnect();

$id = safeGet("course_id");
$NumOfCheck = safeGet("number_box");
$i = 0; //for the for loop
$num = 0; //zero

for ($i; $i < $NumOfCheck; $i = $i + 1) {
    $num = $num + 1;
    $check_box = "checkbox" . $num;
    $student_id = safeGet($check_box);
    if ($student_id != null) {
        Grade::add($id, $student_id);
    }
}
header('Location: ../courses.php');
?>