<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/student.php');
include_once('./models/grade.php');
include_once('./models/Courses.php');
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
<div style="padding: 10px 0px 40px 0px;">
    <button class="button float-right edit_course" id="0">Add Course</button>
</div>

<table class="table">
    <thead>
        <tr id="StudentTable_th">
            <th scope="col">Course ID</th>
            <th scope="col">Course Name</th>
            <th scope="col">Max Degree</th>
            <th scope="col">Study Year</th>
            
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
                <td><?=$Courses->max_degree ?> </td>
                <td><?=$Courses->study_year ?> </td>
                
                <td>
                    <button class="button edit_course" id="<?= $Courses->id ?>">Edit</button>&nbsp;
                    <button class="button delete_course" id="<?= $Courses->id ?>">Delete</button>
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
                        .done(function (reponse) {
                            if (reponse.status == 1) {
                                anchor.closest('tr').fadeOut('slow', function () {
                                    $(this).remove();
                                });
                            }
                        })
                        .fail(function () {
                            alert("Connection error .");
                        })
            });

  ;

    });
</script>

<?php include_once('./components/tail.php') ?>



