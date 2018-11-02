    <?php

include_once("../controllers/common.php");
include_once("../models/grade.php");
Database::DBConnect();
$id = safeGet("id");
$page = safeGet("page");

$grades = new Grade($id, "std");
$grades->course_id = safeGet("course_id");
$grades->degree = safeGet("degree");
$grades->examine_at = safeGet("examine_at");

$grades->save();

if ($page == "std") {
    header('Location: ../students.php');
} else if ($page == "crs") {
    header('Location: ../courses.php');
}
?>