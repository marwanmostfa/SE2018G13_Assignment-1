<?php
include_once("./controllers/common.php");
include_once('./components/head.php');
include_once('./models/Courses.php');
$id = safeGet('id');
Database::connect('school', 'root', '');
$courses = new Courses($id);
?>

<h2 class="mt-4"><?= ($id) ? "Edit" : "Add" ?> Course</h2>

<form action="controllers/savecourse.php" method="post">
    <input type="hidden" name="id" value="<?= $courses->get('id') ?>">
    <div class="card">
        <div class="card-body">
           
            <div class="form-group row gutters">
                <label for="course_name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10" style="margin-bottom: 10px">
                    <input class="form-control" type="text" name="name" value="<?= $courses->get('name') ?>" required>
                </div>
                
                  <label  for="course_year" class="col-sm-2 col-form-label"><p>Study Year</p></label>
                     
                
                      <div class="col-sm-10 ">
                    <input class="form-control" type="text" name="study_year" value="<?= $courses->get('study_year') ?>" required>
                      </div>
                      
                <label for="course_degree" class="col-sm-2 col-form-label">Max Degree</label>
                            
                           
                            <div class="col-sm-10">
                    <input class="form-control" type="text" name="max_degree" value="<?= $courses->get('max_degree') ?>" required>
                </div>  
            </div>
            <div class="form-group">
                <button class="button float-right" type="submit"><?= ($id) ? "Save" : "Add" ?></button>
            </div>
        </div>
    </div>
</form>

<?php include_once('./components/tail.php') ?> 