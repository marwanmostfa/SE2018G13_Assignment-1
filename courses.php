<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/Courses.php');
include_once('./models/grade.php');
Database::DBConnect();
?>

<body>    
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="./index.php"> <i class="fas fa-user-graduate"></i> SIS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
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
                    <th scope="col">Course ID
                        <button class="button idSortbtn"><i class="fas fa-sort-amount-up idSort"></i></button>
                    </th>
                    <th scope="col">Course Name
                        <button class="button nameSortbtn"><i class="fas fa-random nameSort"></i></button>
                    </th>
                    <th scope="col" style="padding-bottom: 18px">Max Degree</th>
                    <th scope="col">Study Year
                        <button class="button yearSortbtn"><i class="fas fa-random yearSort"></i></button>
                    </th>
                    <th scope="col"  style="padding-bottom: 18px">Grade</th>
                    <th scope="col"><button class="button float-right edit_course" id="0">Add Course</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $courses = Courses::all(safeGet('keywords'), NULL, NULL);
                $num = 0;
                foreach ($courses as $Courses) {
                    $num = $num + 1;
                    ?>
                    <tr id="StudentTable_tr" class="crsRow<?= $num ?>">
                        <td class="crsID<?= $num ?>"><?= $Courses->id ?></td>
                        <td class="crsName<?= $num ?>"><?= $Courses->name ?></td>
                        <td class="crsMaxDegree<?= $num ?>"><?= $Courses->max_degree ?> </td>
                        <td class="crsStudyYear<?= $num ?>"><?= $Courses->study_year ?> </td>
                        <td>
                            <button class="button show_grade crsGrade<?= $num ?>" id="<?= $Courses->id ?>">Show</button>
                        </td>
                        <td>
                            <button class="button edit_course crsEdit<?= $num ?>" id="<?= $Courses->id ?>">Edit</button>&nbsp;
                            <button class="button delete_course crsDelete<?= $num ?>" id="<?= $Courses->id ?>">Delete</button>
                        </td>
                    </tr>

                    <tr id="grade<?= $Courses->id ?>" style="display: none">
                        <td colspan="6">
                            <table class="table">
                                <thead>
                                    <tr id="GardeTable_th">
                                        <th scope="col">Student ID
                                            <button class="button stdIDSortbtn" crsID="<?= $Courses->id ?>"><i class="fas fa-sort-amount-up <?= $Courses->id ?>stdIDSort"></i></button>
                                        </th>
                                        <th scope="col">Student Name
                                            <button class="button stdNameSortbtn" crsID="<?= $Courses->id ?>"><i class="fas fa-random <?= $Courses->id ?>stdNameSort"></i></button>
                                        </th>
                                        <th scope="col">Grade
                                            <button class="button gradeSortbtn" crsID="<?= $Courses->id ?>"><i class="fas fa-random <?= $Courses->id ?>gradeSort"></i></button>
                                        </th>
                                        <th scope="col">Examine Date
                                            <button class="button examineatSortbtn" crsID="<?= $Courses->id ?>"><i class="fas fa-random <?= $Courses->id ?>examineatSort"></i></button>
                                        </th>
                                        <th scope="col">
                                            <button class="button float-right add_student"  id="<?= $Courses->id ?>">Assign Students</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grades = Grade::crs_all($Courses->id, NULL, NULL);
                                    $gradenum = 0;
                                    foreach ($grades as $grade) {
                                        $gradenum = $gradenum + 1;
                                        ?>
                                        <tr id="GardeTable_tr">
                                            <td class="<?= $Courses->id ?>gradestdID<?= $gradenum ?>"><?= $grade->student_id ?></td>
                                            <td class="<?= $Courses->id ?>gradestdName<?= $gradenum ?>"><?= $grade->std_name ?></td>
                                            <td class="<?= $Courses->id ?>gradeDegree<?= $gradenum ?>"><?= $grade->degree ?></td>
                                            <td class="<?= $Courses->id ?>gradeExamineAt<?= $gradenum ?>"><?= $grade->examine_at ?></td>
                                            <td>
                                                <button class="button  edit_grade <?= $Courses->id ?>gradeEdit<?= $gradenum ?>" id="<?= $grade->id ?>">Edit</button>&nbsp;
                                                <button class="button delete_grade <?= $Courses->id ?>gradeDelete<?= $gradenum ?>" id="<?= $grade->id ?>">Delete</button>
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

                $('.edit_grade').click(function (event) {
                    window.location.href = "editgrade.php?id=" + $(this).attr('id') + "&page=crs";
                });

                $('.add_student').click(function (event) {
                    window.location.href = "addstudenttocourse.php?id=" + $(this).attr('id');
                });

                $('.delete_course').click(function () {
                    var anchor = $(this);
                    var crsID = anchor.attr('id');
                    $.ajax({
                        url: './controllers/deletecourses.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {id: crsID},
                    })
                            .done(function (response) {
                                if (response.status == 1) {
                                    anchor.closest('tr').fadeOut('slow', function () {
                                        $(this).remove();
                                    });
                                    $("#grade" + crsID).fadeOut('slow');
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
                    $('#grade' + anchor.attr('id')).slideToggle("Slow", function () {
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
                    var status = $('.idSort').attr('class');
                    if (status == "fas fa-sort-amount-down idSort" || status == "fas fa-random idSort") {
                        $('.idSort').attr("class", "fas fa-sort-amount-up idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        $(".yearSort").attr("class", "fas fa-random yearSort");
                        crsViewSorted("id", "ASC");
                    } else if (status == "fas fa-sort-amount-up idSort") {
                        $('.idSort').attr("class", "fas fa-sort-amount-down idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        $(".yearSort").attr("class", "fas fa-random yearSort");
                        crsViewSorted("id", "DESC");
                    }
                });

                $('.nameSortbtn').click(function () {
                    var status = $('.nameSort').attr('class');
                    if (status == "fas fa-sort-amount-down nameSort" || status == "fas fa-random nameSort") {
                        $('.nameSort').attr("class", "fas fa-sort-amount-up nameSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        $(".yearSort").attr("class", "fas fa-random yearSort");
                        crsViewSorted("name", "ASC");
                    } else if (status == "fas fa-sort-amount-up nameSort") {
                        $('.nameSort').attr("class", "fas fa-sort-amount-down nameSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        $(".yearSort").attr("class", "fas fa-random yearSort");
                        crsViewSorted("name", "DESC");
                    }
                });

                $('.yearSortbtn').click(function () {
                    var status = $('.yearSort').attr('class');
                    if (status == "fas fa-sort-amount-down yearSort" || status == "fas fa-random yearSort") {
                        $('.yearSort').attr("class", "fas fa-sort-amount-up yearSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        crsViewSorted("study_year", "ASC");
                    } else if (status == "fas fa-sort-amount-up yearSort") {
                        $('.yearSort').attr("class", "fas fa-sort-amount-down yearSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        crsViewSorted("study_year", "DESC");
                    }
                });

                $('.stdIDSortbtn').click(function () {
                    var crsID = $(this).attr('crsID');
                    var status = $("." + crsID + "stdIDSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + crsID + "stdIDSort" || status == "fas fa-random " + crsID + "stdIDSort") {
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-sort-amount-up " + crsID + "stdIDSort");
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-random " + crsID + "stdNameSort");
                        $("." + crsID + "gradeSort").attr("class", "fas fa-random " + crsID + "gradeSort");
                        $("." + crsID + "examineatSort").attr("class", "fas fa-random " + crsID + "examineatSort");
                        gradeViewSort(crsID, "student_id", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + crsID + "stdIDSort") {
                        $("." + crsID + "stdIDSort").attr('class', "fas fa-sort-amount-down " + crsID + "stdIDSort");
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-random " + crsID + "stdNameSort");
                        $("." + crsID + "gradeSort").attr("class", "fas fa-random " + crsID + "gradeSort");
                        $("." + crsID + "examineatSort").attr("class", "fas fa-random " + crsID + "examineatSort");
                        gradeViewSort(crsID, "student_id", "DESC");
                    }
                });

                $('.stdNameSortbtn').click(function () {
                    var crsID = $(this).attr('crsID');
                    var status = $("." + crsID + "stdNameSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + crsID + "stdNameSort" || status == "fas fa-random " + crsID + "stdNameSort") {
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-sort-amount-up " + crsID + "stdNameSort");
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-random " + crsID + "stdIDSort");
                        $("." + crsID + "gradeSort").attr("class", "fas fa-random " + crsID + "gradeSort");
                        $("." + crsID + "examineatSort").attr("class", "fas fa-random " + crsID + "examineatSort");
                        gradeViewSort(crsID, "std_name", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + crsID + "stdNameSort") {
                        $("." + crsID + "stdNameSort").attr('class', "fas fa-sort-amount-down " + crsID + "stdNameSort");
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-random " + crsID + "stdIDSort");
                        $("." + crsID + "gradeSort").attr("class", "fas fa-random " + crsID + "gradeSort");
                        $("." + crsID + "examineatSort").attr("class", "fas fa-random " + crsID + "examineatSort");
                        gradeViewSort(crsID, "std_name", "DESC");
                    }
                });

                $('.gradeSortbtn').click(function () {
                    var crsID = $(this).attr('crsID');
                    var status = $("." + crsID + "gradeSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + crsID + "gradeSort" || status == "fas fa-random " + crsID + "gradeSort") {
                        $("." + crsID + "gradeSort").attr("class", "fas fa-sort-amount-up " + crsID + "gradeSort");
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-random " + crsID + "stdIDSort");
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-random " + crsID + "stdNameSort");
                        $("." + crsID + "examineatSort").attr("class", "fas fa-random " + crsID + "examineatSort");
                        gradeViewSort(crsID, "degree", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + crsID + "gradeSort") {
                        $("." + crsID + "gradeSort").attr('class', "fas fa-sort-amount-down " + crsID + "gradeSort");
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-random " + crsID + "stdIDSort");
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-random " + crsID + "stdNameSort");
                        $("." + crsID + "examineatSort").attr("class", "fas fa-random " + crsID + "examineatSort");
                        gradeViewSort(crsID, "degree", "DESC");
                    }
                });

                $('.examineatSortbtn').click(function () {
                    var crsID = $(this).attr('crsID');
                    var status = $("." + crsID + "examineatSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + crsID + "examineatSort" || status == "fas fa-random " + crsID + "examineatSort") {
                        $("." + crsID + "examineatSort").attr("class", "fas fa-sort-amount-up " + crsID + "examineatSort");
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-random " + crsID + "stdIDSort");
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-random " + crsID + "stdNameSort");
                        $("." + crsID + "gradeSort").attr("class", "fas fa-random " + crsID + "gradeSort");
                        gradeViewSort(crsID, "examine_at", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + crsID + "examineatSort") {
                        $("." + crsID + "examineatSort").attr('class', "fas fa-sort-amount-down " + crsID + "examineatSort");
                        $("." + crsID + "stdIDSort").attr("class", "fas fa-random " + crsID + "stdIDSort");
                        $("." + crsID + "stdNameSort").attr("class", "fas fa-random " + crsID + "stdNameSort");
                        $("." + crsID + "gradeSort").attr("class", "fas fa-random " + crsID + "gradeSort");
                        gradeViewSort(crsID, "examine_at", "DESC");
                    }
                });


            });

            function crsViewSorted($col, $ord) {
                $.ajax({
                    url: './controllers/coursesort.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {keyword: $("#SearchBox").val(), column: $col, order: $ord},
                })
                        .done(function (response) {
                            var num = 0;
                            response.forEach(function (obj) {
                                num = num + 1;
                                $(".crsID" + num).text(obj.id);
                                $(".crsName" + num).text(obj.name);
                                $(".crsMaxDegree" + num).text(obj.max_degree);
                                $(".crsStudyYear" + num).text(obj.study_year);
                                $(".crsGrade" + num).attr("id", obj.id);
                                $(".crsEdit" + num).attr("id", obj.id);
                                $(".crsDelete" + num).attr("id", obj.id);
                                if ($("#grade" + obj.id).is(':visible')) {
                                    $(".crsGrade" + num).text("Hide");
                                } else {
                                    $(".crsGrade" + num).text("Show");
                                }
                                $(".crsRow" + num).after($("#grade" + obj.id))
                            })
                        })
                        .fail(function () {
                            alert("Connection error.");
                        })
            }

            function gradeViewSort($ID, $col, $ord) {
                var crsdID = $ID;
                $.ajax({
                    url: './controllers/gradesort.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {column: $col, order: $ord, page: "crs", ID: crsdID},
                })
                        .done(function (response) {
                            var num = 0;
                            response.forEach(function (obj) {
                                num = num + 1;
                                $("." + crsdID + "gradestdID" + num).text(obj.student_id);
                                $("." + crsdID + "gradestdName" + num).text(obj.std_name);
                                $("." + crsdID + "gradeDegree" + num).text(obj.degree);
                                $("." + crsdID + "gradeExamineAt" + num).text(obj.examine_at);
                                $("." + crsdID + "gradeEdit" + num).attr("id", obj.id);
                                $("." + crsdID + "gradeDelete" + num).attr("id", obj.id);
                            })
                        })
                        .fail(function () {
                            alert("Connection error.");
                        })
            }

        </script>    