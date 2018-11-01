<?php
include_once("./controllers/common.php");
include_once('./components/head.php');
include_once('./models/student.php');
include_once('./models/grade.php');
include_once('./models/Courses.php');
$id = safeGet('id');
Database::connect('school', 'root', '');
$student = new Student($id);
$grades = (Grade::std_all($student->id, 'std'));
$courses = Courses::all(safeGet('keywords'),null,null);
$mrH=[];
$num=null;
$asd="x";
$check_box="checkbox".$num;

?>

<body>    
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="./Home.php"> <i class="fas fa-user-graduate"></i> SIS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./Home.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./students.php">Students<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./courses.php">Courses</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Begin page content -->
    <main role="main" class="container">

        <h2 class="mt-4"><?= ($id) ? "Edit" : "Add" ?> Student Courses</h2>

        <form action="controllers/addnewcourse.php" method="post" >

            <input type="hidden" name="student_id" value="<?= $student->get('id') ?>">

            <div class="card-body">
                <div class="form-group row gutters"  style="margin-top: 20px">

                    <div >
                        <table class="table  "  >
                           
                            <thead  class="col-sm-20">
                                <tr id="StudentTable_th" >
                                    

                                    <th scope="col" class="col-sm-10">Course Name</th>

                                    <th scope="col" class="col-sm-10">Study Year</th>
    
                                    
                                </tr>
                               
                            </thead>

                            <?php
                            $grades = Grade::std_all($student->id);
                            $sum = 0;
                            foreach ($courses as $course) {
                                $true_counter = 0;
                              
                               
                                foreach ($grades as $grade) {
                                    $sum = $sum + 1;
                                    if ($course->id != $grade->course_id) {
                                        $true_counter = $true_counter + 1;
                                    }
                                }
                                if ($true_counter == $sum) {
                                    $mrH[]=$course->id;
                                    
                                     $num=$num+1;
                                $check_box="checkbox".$num;
                               
                                    ?> 
                                    <tr id="StudentTable_tr">
                                   
                                        <td >
                                            <input type="checkbox"   name=<?= $check_box ?> value="<?= $course->id ?> " class="col-sm-10 form-control" >  <?= $course->name  ?> 
                                        </td>
                                 
                                        <td>
                                            <?=$course->study_year   ?>
                                           
                                        </td>
                                    </tr>

                                    <?php
                                }
                                $sum = 0;
                            }
                            ?>

                        </table>
                    </div>

<?php

?>

                    <div class="form-group">
                        <button class="button float-right" name="number_box" value="<?= $num?>" type="submit"><?= "Add" ?></button>
                    </div>
                </div>
                </<div>

                </div>
 <input type="checkbox"   name="" value="y" class="col-sm-10 form-control" > 
                                   
        </form>

        <?php include_once('./components/tail.php') ?>