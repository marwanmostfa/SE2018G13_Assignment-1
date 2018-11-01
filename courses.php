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
                <?php
                $id_icon = safeGet("idIcon");
                $name_icon = safeGet("nameIcon");
                $year_icon = safeGet("yearIcon");
                ?>
                <tr id="StudentTable_th">
                    <th scope="col">Course ID
                        <button class="button idSortbtn"><i class="<?= ($id_icon == null) ? "fas fa-sort-amount-up idSort" : $id_icon ?>"></i></button>
                    </th>
                    <th scope="col">Course Name
                        <button class="button nameSortbtn"><i class="<?= ($name_icon == null) ? "fas fa-random nameSort" : $name_icon ?>"></i></button>
                    </th>
                    <th scope="col" style="padding-bottom: 18px">Max Degree</th>
                    <th scope="col">Study Year
                        <button class="button yearSortbtn"><i class="<?= ($year_icon == null) ? "fas fa-random yearSort" : $year_icon ?>"></i></button>
                    </th>
                    <th scope="col"  style="padding-bottom: 18px">Grade</th>
                    <th scope="col"><button class="button float-right edit_course" id="0">Add Course</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $courses = Courses::all(safeGet('keywords'), safeGet("column"), safeGet("order"));
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
                                                <button class="button  edit_grade" id="<?= $grade->id ?>">Edit</button>&nbsp;
                                                <button class="button delete_grade" id="<?= $grade->id ?>">Delete</button>
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

        <form style="display: hidden" action="courses.php" method="POST" id="form">
            <input type="hidden" id="column" name="column" value=""/>
            <input type="hidden" id="order" name="order" value=""/>
            <input type="hidden" id="idIcon" name="idIcon" value=""/>
            <input type="hidden" id="nameIcon" name="nameIcon" value=""/>
            <input type="hidden" id="yearIcon" name="yearIcon" value=""/>
        </form>

        <?php include_once('./components/tail.php') ?>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.edit_course').click(function (event) {
                    window.location.href = "editcourse.php?id=" + $(this).attr('id');

                });

                $('.edit_grade').click(function (event) {
                    window.location.href = "editgrade.php?id=" + $(this).attr('id') + "&page=crs";
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

                $('.delete_grade').click(function () {
                    var anchor = $(this);
                    $.ajax({
                        url: './controllers/deletegrade.php',
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

                $('.idSortbtn').click(function () {
                    var anchor = $('.idSort');
                    var status = anchor.attr('class');
                    if (status == "fas fa-sort-amount-down idSort") {
                        $("#column").val("id");
                        $("#order").val("ASC");
                        $("#idIcon").val("fas fa-sort-amount-up idSort");
                        $("#nameIcon").val("fas fa-random nameSort");
                        $("#yearIcon").val("fas fa-random yearSort");
                    } else if (status == "fas fa-sort-amount-up idSort") {
                        $("#column").val("id");
                        $("#order").val("DESC");
                        $("#idIcon").val("fas fa-sort-amount-down idSort");
                        $("#nameIcon").val("fas fa-random nameSort");
                        $("#yearIcon").val("fas fa-random yearSort");
                    } else if (status == "fas fa-random idSort") {
                        $("#column").val("id");
                        $("#order").val("ASC");
                        $("#idIcon").val("fas fa-sort-amount-up idSort");
                        $("#nameIcon").val("fas fa-random nameSort");
                        $("#yearIcon").val("fas fa-random yearSort");
                    }
                    $("#form").submit();
                });

                $('.nameSortbtn').click(function () {
                    var anchor = $('.nameSort');
                    var status = anchor.attr('class');
                    if (status == "fas fa-sort-amount-down nameSort") {
                        $("#column").val("name");
                        $("#order").val("ASC");
                        $("#nameIcon").val("fas fa-sort-amount-up nameSort");
                        $("#idIcon").val("fas fa-random idSort");
                        $("#yearIcon").val("fas fa-random yearSort");
                    } else if (status == "fas fa-sort-amount-up nameSort") {
                        $("#column").val("name");
                        $("#order").val("DESC");
                        $("#nameIcon").val("fas fa-sort-amount-down nameSort");
                        $("#idIcon").val("fas fa-random idSort");
                        $("#yearIcon").val("fas fa-random yearSort");
                    } else if (status == "fas fa-random nameSort") {
                        $("#column").val("name");
                        $("#order").val("ASC");
                        $("#nameIcon").val("fas fa-sort-amount-up nameSort");
                        $("#idIcon").val("fas fa-random idSort");
                        $("#yearIcon").val("fas fa-random yearSort");
                    }
                    $("#form").submit();
                });

                $('.yearSortbtn').click(function () {
                    var anchor = $('.yearSort');
                    var status = anchor.attr('class');
                    if (status == "fas fa-sort-amount-down yearSort") {
                        $("#column").val("study_year");
                        $("#order").val("ASC");
                        $("#yearIcon").val("fas fa-sort-amount-up yearSort");
                        $("#idIcon").val("fas fa-random idSort");
                        $("#nameIcon").val("fas fa-random nameSort");
                    } else if (status == "fas fa-sort-amount-up yearSort") {
                        $("#column").val("study_year");
                        $("#order").val("DESC");
                        $("#yearIcon").val("fas fa-sort-amount-down yearSort");
                        $("#idIcon").val("fas fa-random idSort");
                        $("#nameIcon").val("fas fa-random nameSort");
                    } else if (status == "fas fa-random yearSort") {
                        $("#column").val("study_year");
                        $("#order").val("ASC");
                        $("#yearIcon").val("fas fa-sort-amount-up yearSort");
                        $("#idIcon").val("fas fa-random idSort");
                        $("#nameIcon").val("fas fa-random nameSort");
                    }
                    $("#form").submit();
                });

            });
        </script>    