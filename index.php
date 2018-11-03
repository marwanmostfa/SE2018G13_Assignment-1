<?php include_once('./controllers/common.php') ?>
<?php include_once('./components/head.php') ?>

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
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./students.php">Students</a>
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

        <h1 class="mt-5">School Information System</h1>
        <p class="lead" style="padding-bottom: 25px">Manage school information like students, course and grades.</p>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-box">
                        <div class="card-title">
                            <h2>Team Members (G13)</h2>
                            <ul>
                                <li>Ibrahim Amr</li>
                                <li>Ahmed Hessuin</li>
                                <li>Ahmed Osama</li>
                                <li>Ahmed Saeid</li>
                                <li>Eslam Tarek</li>
                                <li>Marwan Mostafa</li>
                                <li>Mohammed Adel</li>
                            </ul>
                        </div>
                        <div class="card-link">
                            <a href="https://github.com/IbrahimAmrIbrahim/SE2018G13_Assignment-1" class="c-link" target="_blank">GitHub repository
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <br>
                            <a href="https://drive.google.com/open?id=1-TXRnFKvRnwBwWYoGuQfXf4Ye3yewjtE" class="c-link" target="_blank">Source File
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('./components/tail.php') ?>