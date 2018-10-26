<?php
include_once('./controllers/common.php');
include_once('./components/head.php');
include_once('./models/student.php');
Database::connect('school', 'root', '');
?>

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
                    <button class="button edit_student" id="<?= $student->id ?>">Edit</button>&nbsp;
                    <button class="button delete_student" id="<?= $student->id ?>">Delete</button>
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
    });
</script>