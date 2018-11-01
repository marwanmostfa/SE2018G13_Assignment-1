<?php

include_once("../controllers/common.php");
include_once("../models/student.php");
include_once("../controllers/common.php");
include_once("../models/grade.php");
Database::connect('school', 'root', '');

$id = safeGet("student_id");
$NumOfCheck = safeGet("number_box");
$i = 0; //for the for loop
$num = null; //zero

for ($i; $i < $NumOfCheck; $i = $i + 1) {
    $num = $num + 1;
    $check_box = "checkbox" . $num;
    $studentid = "x"; //dumy
    $checkdata = safeGet($check_box);
    echo" --$checkdata --";
    
  
    if ($checkdata != null) {
        Grade::add($checkdata, $id, null, null);
    }
}

?>
