<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/student.php');
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
        <h2 class="mt-5">Students</h2>

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
        <table class="table" style="margin-top: 20px">
            <thead>
                <tr id="StudentTable_th">
                    <th scope="col">Student ID
                        <button class="button idSortbtn"><i class="fas fa-sort-amount-up idSort"></i></button>
                    </th>
                    <th scope="col">Student Name
                        <button class="button nameSortbtn"><i class="fas fa-random nameSort"></i></button>
                    </th>
                    <th scope="col"  style="padding-bottom: 18px">Grade</th>
                    <th scope="col"><button class="button float-right edit_student" id="0">Add Student</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $students = Student::all(safeGet('keywords'), NULL, NULL);
                $num = 0;
                foreach ($students as $student) {
                    $num = $num + 1;
                    ?>
                    <tr id="StudentTable_tr" class="stdRow<?= $num ?>">
                        <td class="stdID<?= $num ?>"><?= $student->id ?></td>
                        <td class="stdName<?= $num ?>"><?= $student->name ?></td>
                        <td>
                            <button class="button show_grade stdGrade<?= $num ?>" id="<?= $student->id ?>">Show</button>
                        </td>
                        <td>
                            <button class="button edit_student stdEdit<?= $num ?>" id="<?= $student->id ?>">Edit</button>&nbsp;
                            <button class="button delete_student stdDelete<?= $num ?>" id="<?= $student->id ?>">Delete</button>
                        </td>
                    </tr>
                    <tr id="grade<?= $student->id ?>" style="display: none">
                        <td colspan="4">
                            <table class="table">
                                <thead>
                                    <tr id="GardeTable_th">
                                        <th scope="col">Course ID
                                            <button class="button crsIDSortbtn" stdID="<?= $student->id ?>"><i class="fas fa-sort-amount-up <?= $student->id ?>crsIDSort"></i></button>
                                        </th>
                                        <th scope="col">Course Name
                                            <button class="button crsNameSortbtn" stdID="<?= $student->id ?>"><i class="fas fa-random <?= $student->id ?>crsNameSort"></i></button>
                                        </th>
                                        <th scope="col">Grade
                                            <button class="button gradeSortbtn" stdID="<?= $student->id ?>"><i class="fas fa-random <?= $student->id ?>gradeSort"></i></button>
                                        </th>
                                        <th scope="col">Max Grade</th>
                                        <th scope="col">Examine Date
                                            <button class="button examineatSortbtn" stdID="<?= $student->id ?>"><i class="fas fa-random <?= $student->id ?>examineatSort"></i></button>
                                        </th>
                                        <th scope="col"><button class="button float-right add_Courses" id="<?= $student->id ?>">Assign Courses</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grades = Grade::std_all($student->id, NULL, NULL);
                                    $gradenum = 0;
                                    foreach ($grades as $grade) {
                                        $gradenum = $gradenum + 1;
                                        ?>
                                        <tr id="GardeTable_tr">
                                            <td class="<?= $student->id ?>gradeCrsID<?= $gradenum ?>"><?= $grade->course_id ?></td>
                                            <td class="<?= $student->id ?>gradeCrsName<?= $gradenum ?>"><?= $grade->crs_name ?></td>
                                            <td class="<?= $student->id ?>gradeDegree<?= $gradenum ?>"><?= $grade->degree ?></td>
                                            <td class="<?= $student->id ?>gradeMaxDegree<?= $gradenum ?>"><?= $grade->max_degree ?></td>
                                            <td class="<?= $student->id ?>gradeExamineAt<?= $gradenum ?>"><?= $grade->examine_at ?></td>
                                            <td>
                                                <button class="button edit_grade <?= $student->id ?>gradeEdit<?= $gradenum ?>"  id="<?= $grade->id ?>">Edit</button>&nbsp;
                                                <button class="button delete_grade <?= $student->id ?>gradeDelete<?= $gradenum ?>" id="<?= $grade->id ?>">Delete</button>
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

                $('.edit_grade').click(function (event) {
                    window.location.href = "editgrade.php?id=" + $(this).attr('id') + "&page=std";
                });

                $('.add_Courses').click(function (event) {
                    window.location.href = "addcoursetostudent.php?id=" + $(this).attr('id');
                });

                $('.delete_student').click(function () {
                    var anchor = $(this);
                    var stdID = anchor.attr('id');
                    $.ajax({
                        url: './controllers/deletestudent.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {id: stdID},
                    })
                            .done(function (response) {
                                if (response.status == 1) {
                                    anchor.closest('tr').fadeOut('slow', function () {
                                        $(this).remove();
                                    });
                                    $("#grade" + stdID).fadeOut('slow');
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
                        stdViewSort("id", "ASC");
                    } else if (status == "fas fa-sort-amount-up idSort") {
                        $('.idSort').attr('class', "fas fa-sort-amount-down idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        stdViewSort("id", "DESC");
                    }
                });

                $('.nameSortbtn').click(function () {
                    var status = $('.nameSort').attr('class');
                    if (status == "fas fa-sort-amount-down nameSort" || status == "fas fa-random nameSort") {
                        $('.nameSort').attr("class", "fas fa-sort-amount-up nameSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        stdViewSort("name", "ASC");
                    } else if (status == "fas fa-sort-amount-up nameSort") {
                        $('.nameSort').attr('class', "fas fa-sort-amount-down nameSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        stdViewSort("name", "DESC");
                    }
                });

                $('.crsIDSortbtn').click(function () {
                    var stdID = $(this).attr('stdID');
                    var status = $("." + stdID + "crsIDSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + stdID + "crsIDSort" || status == "fas fa-random " + stdID + "crsIDSort") {
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-sort-amount-up " + stdID + "crsIDSort");
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-random " + stdID + "crsNameSort");
                        $("." + stdID + "gradeSort").attr("class", "fas fa-random " + stdID + "gradeSort");
                        $("." + stdID + "examineatSort").attr("class", "fas fa-random " + stdID + "examineatSort");
                        gradeViewSort(stdID, "course_id", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + stdID + "crsIDSort") {
                        $("." + stdID + "crsIDSort").attr('class', "fas fa-sort-amount-down " + stdID + "crsIDSort");
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-random " + stdID + "crsNameSort");
                        $("." + stdID + "gradeSort").attr("class", "fas fa-random " + stdID + "gradeSort");
                        $("." + stdID + "examineatSort").attr("class", "fas fa-random " + stdID + "examineatSort");
                        gradeViewSort(stdID, "course_id", "DESC");
                    }
                });

                $('.crsNameSortbtn').click(function () {
                    var stdID = $(this).attr('stdID');
                    var status = $("." + stdID + "crsNameSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + stdID + "crsNameSort" || status == "fas fa-random " + stdID + "crsNameSort") {
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-sort-amount-up " + stdID + "crsNameSort");
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-random " + stdID + "crsIDSort");
                        $("." + stdID + "gradeSort").attr("class", "fas fa-random " + stdID + "gradeSort");
                        $("." + stdID + "examineatSort").attr("class", "fas fa-random " + stdID + "examineatSort");
                        gradeViewSort(stdID, "crs_name", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + stdID + "crsNameSort") {
                        $("." + stdID + "crsNameSort").attr('class', "fas fa-sort-amount-down " + stdID + "crsNameSort");
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-random " + stdID + "crsIDSort");
                        $("." + stdID + "gradeSort").attr("class", "fas fa-random " + stdID + "gradeSort");
                        $("." + stdID + "examineatSort").attr("class", "fas fa-random " + stdID + "examineatSort");
                        gradeViewSort(stdID, "crs_name", "DESC");
                    }
                });

                $('.gradeSortbtn').click(function () {
                    var stdID = $(this).attr('stdID');
                    var status = $("." + stdID + "gradeSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + stdID + "gradeSort" || status == "fas fa-random " + stdID + "gradeSort") {
                        $("." + stdID + "gradeSort").attr("class", "fas fa-sort-amount-up " + stdID + "gradeSort");
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-random " + stdID + "crsIDSort");
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-random " + stdID + "crsNameSort");
                        $("." + stdID + "examineatSort").attr("class", "fas fa-random " + stdID + "examineatSort");
                        gradeViewSort(stdID, "degree", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + stdID + "gradeSort") {
                        $("." + stdID + "gradeSort").attr('class', "fas fa-sort-amount-down " + stdID + "gradeSort");
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-random " + stdID + "crsIDSort");
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-random " + stdID + "crsNameSort");
                        $("." + stdID + "examineatSort").attr("class", "fas fa-random " + stdID + "examineatSort");
                        gradeViewSort(stdID, "degree", "DESC");
                    }
                });

                $('.examineatSortbtn').click(function () {
                    var stdID = $(this).attr('stdID');
                    var status = $("." + stdID + "examineatSort").attr('class');
                    if (status == "fas fa-sort-amount-down " + stdID + "examineatSort" || status == "fas fa-random " + stdID + "examineatSort") {
                        $("." + stdID + "examineatSort").attr("class", "fas fa-sort-amount-up " + stdID + "examineatSort");
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-random " + stdID + "crsIDSort");
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-random " + stdID + "crsNameSort");
                        $("." + stdID + "gradeSort").attr("class", "fas fa-random " + stdID + "gradeSort");
                        gradeViewSort(stdID, "examine_at", "ASC");
                    } else if (status == "fas fa-sort-amount-up " + stdID + "examineatSort") {
                        $("." + stdID + "examineatSort").attr('class', "fas fa-sort-amount-down " + stdID + "examineatSort");
                        $("." + stdID + "crsIDSort").attr("class", "fas fa-random " + stdID + "crsIDSort");
                        $("." + stdID + "crsNameSort").attr("class", "fas fa-random " + stdID + "crsNameSort");
                        $("." + stdID + "gradeSort").attr("class", "fas fa-random " + stdID + "gradeSort");
                        gradeViewSort(stdID, "examine_at", "DESC");
                    }
                });

            });

            function stdViewSort($col, $ord) {
                $.ajax({
                    url: './controllers/studentsort.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {keyword: $("#SearchBox").val(), column: $col, order: $ord},
                })
                        .done(function (response) {
                            var num = 0;
                            response.forEach(function (obj) {
                                num = num + 1;
                                $(".stdID" + num).text(obj.id);
                                $(".stdName" + num).text(obj.name);
                                $(".stdGrade" + num).attr("id", obj.id);
                                $(".stdEdit" + num).attr("id", obj.id);
                                $(".stdDelete" + num).attr("id", obj.id);
                                if ($("#grade" + obj.id).is(':visible')) {
                                    $(".stdGrade" + num).text("Hide");
                                } else {
                                    $(".stdGrade" + num).text("Show");
                                }
                                $(".stdRow" + num).after($("#grade" + obj.id))
                            })
                        })
                        .fail(function () {
                            alert("Connection error.");
                        })
            }

            function gradeViewSort($ID, $col, $ord) {
                var stdID = $ID;
                $.ajax({
                    url: './controllers/gradesort.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {column: $col, order: $ord, page: "std", ID: stdID},
                })
                        .done(function (response) {
                            var num = 0;
                            response.forEach(function (obj) {
                                num = num + 1;
                                $("." + stdID + "gradeCrsID" + num).text(obj.course_id);
                                $("." + stdID + "gradeCrsName" + num).text(obj.crs_name);
                                $("." + stdID + "gradeDegree" + num).text(obj.degree);
                                $("." + stdID + "gradeMaxDegree" + num).text(obj.max_degree);
                                $("." + stdID + "gradeExamineAt" + num).text(obj.examine_at);
                                $("." + stdID + "gradeEdit" + num).attr("id", obj.id);
                                $("." + stdID + "gradeDelete" + num).attr("id", obj.id);
                            })
                        })
                        .fail(function () {
                            alert("Connection error.");
                        })
            }
        </script>
