<?php
include_once("./controllers/common.php");
include_once('./components/head.php');
include_once('./models/student.php');
$id = safeGet('id');
Database::DBConnect();
$student = new Student($id);
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

        <h2 class="mt-5"><?= ($id) ? "Edit" : "Add" ?> Student</h2>

        <form action="controllers/savestudent.php" method="post">
            <input type="hidden" name="id" value="<?= $student->get('id') ?>">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row gutters">
                        <?php
                        if (($id) != 0) {
                            ?>
                            <label for="IDInput" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10" style="padding-bottom: 10px">
                                <input class="form-control" id="IDInput" type="text" value="<?= $student->get('id') ?>" disabled>
                            </div>                        
                            <?php
                        }
                        ?>
                        <label for="nameInput" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nameInput" type="text" name="name" value="<?= $student->get('name') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="button float-right" type="submit"><?= ($id) ? "Save" : "Add" ?></button>
                    </div>
                </div>
            </div>
        </form>

        <?php include_once('./components/tail.php') ?>