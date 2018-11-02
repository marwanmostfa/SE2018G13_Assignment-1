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
                        <button class="button idSortbtn" var="<?= safeGet('keywords') ?>"><i class="fas fa-sort-amount-up idSort"></i></button>
                    </th>
                    <th scope="col">Student Name
                        <button class="button nameSortbtn" var="<?= safeGet('keywords') ?>"><i class="fas fa-random nameSort"></i></button>
                    </th>
                    <th scope="col"  style="padding-bottom: 18px">Grade</th>
                    <th scope="col"><button class="button float-right edit_student" id="0">Add Student</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $students = Student::all(safeGet('keywords'), safeGet("column"), safeGet("order"));
                $num = 0;
                foreach ($students as $student) {
                    $num = $num + 1;
                    ?>
                    <tr id="StudentTable_tr">
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
                                    <?php
                                    $crs_id = safeGet("crsIDIcon");
                                    $crs_name = safeGet("crsNameIcon");
                                    $grade = safeGet("gradeIcon");
                                    $examineat = safeGet("examineatIcon");
                                    ?>
                                    <tr id="GardeTable_th">
                                        <th scope="col">Course ID
                                            <button class="button crsIDSortbtn"><i class="<?= ($crs_id == null) ? "fas fa-sort-amount-up crsIDSort" : $crs_id ?>"></i></button>
                                        </th>
                                        <th scope="col">Course Name
                                            <button class="button crsNameSortbtn"><i class="<?= ($crs_name == null) ? "fas fa-sort-amount-up crsNameSort" : $crs_name ?>"></i></button>
                                        </th>
                                        <th scope="col">Grade
                                            <button class="button gradeSortbtn"><i class="<?= ($grade == null) ? "fas fa-sort-amount-up gradeSort" : $grade ?>"></i></button>
                                        </th>
                                        <th scope="col">Max Grade</th>
                                        <th scope="col">Examine Date
                                            <button class="button examineatSortbtn"><i class="<?= ($examineat == null) ? "fas fa-sort-amount-up examineatSort" : $examineat ?>"></i></button>
                                        </th>
                                        <th scope="col"><button class="button float-right add_Courses" id="<?= $student->id ?>">Add Courses</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grades = Grade::std_all($student->id);
                                    foreach ($grades as $grade) {
                                        ?>
                                        <tr id="GardeTable_tr">
                                            <td><?= $grade->course_id ?></td>
                                            <td><?= $grade->crs_name ?></td>
                                            <td style= "<?php if ($grade->degree > (0.3 * $grade->max_degree)) { ?>
                                                    color: #008000;
                                                <?php } else { ?>
                                                    color: #FF0000;
                                                <?php } ?>"><?= $grade->degree ?></td>
                                            <td><?= $grade->max_degree ?></td>
                                            <td><?= $grade->examine_at ?></td>
                                            <td>
                                                <button class="button edit_grade"  id="<?= $grade->id ?>">Edit</button>&nbsp;
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

        <form style="display: hidden" action="students.php" method="POST" id="form">
            <input type="hidden" id="column" name="column" value=""/>
            <input type="hidden" id="order" name="order" value=""/>
            <input type="hidden" id="idIcon" name="idIcon" value=""/>
            <input type="hidden" id="nameIcon" name="nameIcon" value=""/>
        </form>

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
                    window.location.href = "addcourse.php?id=" + $(this).attr('id');
                });

                $('.delete_student').click(function () {
                    var anchor = $(this);
                    $.ajax({
                        url: './controllers/deletestudent.php',
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
                    if (status == "fas fa-sort-amount-down idSort" || status == "fas fa-random idSort") {
                        anchor.attr("class", "fas fa-sort-amount-up idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        $.ajax({
                            url: './controllers/studentsort.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {keyword: $(this).attr('var'), column: "id", order: "ASC"},
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

                                    })
                                })
                                .fail(function () {
                                    alert("Connection error.");
                                })
                    } else if (status == "fas fa-sort-amount-up idSort") {
                        anchor.attr('class', "fas fa-sort-amount-down idSort");
                        $(".nameSort").attr("class", "fas fa-random nameSort");
                        $.ajax({
                            url: './controllers/studentsort.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {keyword: $(this).attr('var'), column: "id", order: "DESC"},
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

                                    })
                                })
                                .fail(function () {
                                    alert("Connection error.");
                                })
                    }



                    /*     var anchor = $('.idSort');
                     var status = anchor.attr('class');
                     if (status == "fas fa-sort-amount-down idSort") {
                     $("#column").val("id");
                     $("#order").val("ASC");
                     $("#idIcon").val("fas fa-sort-amount-up idSort");
                     $("#nameIcon").val("fas fa-random nameSort");
                     } else if (status == "fas fa-sort-amount-up idSort") {
                     $("#column").val("id");
                     $("#order").val("DESC");
                     $("#idIcon").val("fas fa-sort-amount-down idSort");
                     $("#nameIcon").val("fas fa-random nameSort");
                     } else if (status == "fas fa-random idSort") {
                     $("#column").val("id");
                     $("#order").val("ASC");
                     $("#idIcon").val("fas fa-sort-amount-up idSort");
                     $("#nameIcon").val("fas fa-random nameSort");
                     }
                     $("#form").submit();*/
                });

                $('.nameSortbtn').click(function () {

                    var anchor = $('.nameSort');
                    var status = anchor.attr('class');
                    if (status == "fas fa-sort-amount-down nameSort" || status == "fas fa-random nameSort") {
                        anchor.attr("class", "fas fa-sort-amount-up nameSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        $.ajax({
                            url: './controllers/studentsort.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {keyword: $(this).attr('var'), column: "name", order: "ASC"},
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

                                    })
                                })
                                .fail(function () {
                                    alert("Connection error.");
                                })
                    } else if (status == "fas fa-sort-amount-up nameSort") {
                        anchor.attr('class', "fas fa-sort-amount-down nameSort");
                        $(".idSort").attr("class", "fas fa-random idSort");
                        $.ajax({
                            url: './controllers/studentsort.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {keyword: $(this).attr('var'), column: "name", order: "DESC"},
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

                                    })
                                })
                                .fail(function () {
                                    alert("Connection error.");
                                })
                    }



                    /* var anchor = $('.nameSort');
                     var status = anchor.attr('class');
                     if (status == "fas fa-sort-amount-down nameSort") {
                     $("#column").val("name");
                     $("#order").val("ASC");
                     $("#nameIcon").val("fas fa-sort-amount-up nameSort");
                     $("#idIcon").val("fas fa-random idSort");
                     } else if (status == "fas fa-sort-amount-up nameSort") {
                     $("#column").val("name");
                     $("#order").val("DESC");
                     $("#nameIcon").val("fas fa-sort-amount-down nameSort");
                     $("#idIcon").val("fas fa-random idSort");
                     } else if (status == "fas fa-random nameSort") {
                     $("#column").val("name");
                     $("#order").val("ASC");
                     $("#nameIcon").val("fas fa-sort-amount-up nameSort");
                     $("#idIcon").val("fas fa-random idSort");
                     }
                     $("#form").submit();*/
                });
            }
            );
        </script>
