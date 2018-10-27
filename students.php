<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/student.php');
include_once('./models/grade.php');
Database::connect('school', 'root', '');
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

        <div>
            <span style="font-size: 125%;">Students</span>
        </div>
        <div>
            <form action="./students.php" class="form-inline">
                <div class="input-group" style="width: 100%">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" id="SearchBox" type="text" name="keywords" placeholder="Search" aria-label="Search" value="<?= safeGet('keywords') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div style="padding: 10px 0px 40px 0px;">
            <button class="button float-right edit_student" id="0">Add Student</button>
        </div>

        <table class="table">
            <thead>
                <tr id="StudentTable_th">
                    <th scope="col">Student ID</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Grade</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $students = Student::all(safeGet('keywords'));
                foreach ($students as $student) {
                    ?>
                    <tr id="StudentTable_tr">
                        <td><?= $student->id ?></td>
                        <td><?= $student->name ?></td>
                        <td>
                            <button class="button show_grade" id="<?= $student->id ?>">Show</button>
                        </td>
                        <td>
                            <button class="button edit_student" id="<?= $student->id ?>">Edit</button>&nbsp;
                            <button class="button delete_student" id="<?= $student->id ?>">Delete</button>
                        </td>
                    </tr>
                    <tr id="grade<?= $student->id ?>" style="display: none">
                        <td colspan="4">
                            <table class="table">
                                <thead>
                                    <tr id="GardeTable_th">
                                        <th scope="col">Course ID</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Examine Date</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grades = Grade::all($student->id);
                                    foreach ($grades as $grade) {
                                        ?>
                                        <tr id="GardeTable_tr">
                                            <td><?= $grade->course_id ?></td>
                                            <td><?= $grade->degree ?></td>
                                            <td><?= $grade->examine_at ?></td>
                                            <td>
                                                <button class="button" id="<?= $grade->id ?>">Edit</button>&nbsp;
                                                <button class="button" id="<?= $grade->id ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php include_once('./components/tail.php') ?>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.edit_student').click(function (event) {
                    window.location.href = "editstudent.php?id=" + $(this).attr('id');
                });

                $('.delete_student').click(function () {
                    var anchor = $(this);
                    $.ajax({
                        url: './controllers/deletestudent.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {id: anchor.attr('id')},
                    })
                            .done(function (reponse) {
                                if (reponse.status == 1) {
                                    anchor.closest('tr').fadeOut('slow', function () {
                                        $(this).remove();
                                    });
                                }
                            })
                            .fail(function () {
                                alert("Connection error.");
                            })
                });

                $('.show_grade').click(function () {
                    var anchor = $(this);
                    $('#grade' + anchor.attr('id')).slideToggle("Fast", function () {
                        var status = anchor.text();
                        if (status == "Show") {
                            anchor.text("Hide");
                        } else if (status == "Hide")
                        {
                            anchor.text("Show");
                        }
                    });
                });

            });
        </script>