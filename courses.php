<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/Courses.php');
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


        <h2 class="mt-5">Courses</h2>

        <div>
            <form action="courses.php" class="form-inline">
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

        <table class="table" style="margin-top: 20px">
            <thead>
                <tr id="StudentTable_th">
                    <th scope="col">Course ID</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Max Degree</th>
                    <th scope="col">Study Year</th>
                    <th scope="col">Grade</th>
                    <th scope="col"><button class="button float-right edit_course" id="0">Add Course</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $courses = Courses::all(safeGet('keywords'));
                foreach ($courses as $Courses) {
                    ?>
                    <tr id="StudentTable_tr">
                        <td><?= $Courses->id ?></td>
                        <td><?= $Courses->name ?></td>
                        <td><?= $Courses->max_degree ?> </td>
                        <td><?= $Courses->study_year ?> </td>
                        <td>
                            <button class="button show_grade" id="<?= $Courses->id ?>">Show</button>
                        </td>
                        <td>
                            <button class="button edit_course" id="<?= $Courses->id ?>">Edit</button>&nbsp;
                            <button class="button delete_course" id="<?= $Courses->id ?>">Delete</button>
                        </td>
                    </tr>

                    <tr id="grade<?= $Courses->id ?>" style="display: none">
                        <td colspan="6">
                            <table class="table">
                                <thead>
                                    <tr id="GardeTable_th">
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Examine Date</th>
                                        <th scope="col"><button class="button float-right" id="0">Add Grade</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grades = Grade::crs_all($Courses->id);
                                    foreach ($grades as $grade) {
                                        ?>
                                        <tr id="GardeTable_tr">
                                            <td><?= $grade->student_id ?></td>
                                            <td><?= $grade->std_name ?></td>
                                            <td style= "<?php if ($grade->degree > (0.3 * $grade->max_degree)) { ?>
                                                    color: #008000;
                                                <?php } else { ?>
                                                    color: #FF0000;
                                                <?php } ?>"><?= $grade->degree ?></td>
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
                $('.edit_course').click(function (event) {
                    window.location.href = "editcourse.php?id=" + $(this).attr('id');

                });

                $('.delete_course').click(function () {
                    var anchor = $(this);
                    $.ajax({
                        url: './controllers/deletecourses.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {id: anchor.attr('id')},
                    })
                            .done(function (response) {
                                if (response.status == 1) {
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