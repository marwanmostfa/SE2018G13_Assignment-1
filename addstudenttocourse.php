<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/Courses.php');
include_once('./models/grade.php');
include_once('./models/Student.php');
Database::connect('school', 'root', '');
$id = safeGet('id'); // course id
$students = Student::all(safeGet('keywords'), null, null);
$num=null;
$grades = Grade::crs_all($id);
?>

<form action="controllers/addnewstudent.php" method="post">
       <input type="hidden" name="course_id" value="<?= $id ?>">
<table>


<?php
foreach ($students as $student) {
    $flag = TRUE;
    foreach ($grades as $grade) {
        if ($student->id == $grade->student_id) {
            $flag = FALSE;
            break;
        }
    }
    if ($flag == TRUE) {
        $num = $num + 1;
        $check_box = "checkbox" . $num;
        ?> 
            <tr id="addCourseTable_tr">
                <td>
                    <div class="checkbox">
                        <input type="checkbox" name="<?= $check_box ?>" value="<?= $student->id ?>"> <?= $student->name ?>
                    </div>
                </td>
                <td>  <?= $student->id?></td>
            </tr>
        <?php
    }
}
?>
            
            
         <div class="form-group col-sm-12">
                            <button class="button float-right" type="submit" name="number_box" value="<?= $num ?>" >Add</button>
                        </div>

</table>  
</form>