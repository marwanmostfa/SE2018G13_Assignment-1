<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/Student.php');
include_once('./models/Courses.php');
include_once('./models/grade.php');
Database::connect('school', 'root', '');
$id = safeGet('id'); // course id
$students = Student::all(safeGet('keywords'), null, null);
$grades = Grade::crs_all($id);
$num = 0;
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
                    <li class="nav-item">
                        <a class="nav-link" href="./students.php">Students</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./courses.php">Courses<span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Begin page content -->
    <main role="main" class="container">
        <h2 class="mt-5">Add Students to Course</h2>
        <form action="controllers/addnewstudent.php" method="post">
            <input type="hidden" name="course_id" value="<?= $id ?>">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row gutters"  style="margin-top: 20px">
                        <div class="form-group col-sm-12">
                            <table class="table col-sm-12">
                                <thead>
                                    <tr id="addCourseTable_th" >
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Student ID</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                                <td>  <?= $student->id ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group col-sm-12">
                            <button class="button float-right" type="submit" name="number_box" value="<?= $num ?>" >Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php include_once('./components/tail.php') ?>