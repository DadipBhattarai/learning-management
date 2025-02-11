<?php include('header.php'); ?>
<?php include('session.php'); ?>

<head>
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background-color: #f4f7fc;
        }

        .dashboard-container {
            padding: 30px;
        }

        .row_lms {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }

        .card_lms {
            flex: 1 1 calc(20% - 20px);
            max-width: 25%;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #ffffff, #e6ecf5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card_lms:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card_lms h5 {
            margin: 10px 0;
            font-size: 28px;
            color: #333;
            font-weight: bold;
        }

        .card_lms p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }

        .rounded-circle_lms {
            width: 70px;
            height: 70px;
            line-height: 70px;
            border-radius: 50%;
            margin: 0 auto 15px;
            font-size: 30px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* Individual Colors */
        .bg-primary_lms {
            background: #007bff;
        }

        .bg-info_lms {
            background: #17a2b8;
        }

        .bg-success_lms {
            background: #28a745;
        }

        .bg-warning_lms {
            background: #ffc107;
        }

        .bg-secondary_lms {
            background: #6c757d;
        }

        .bg-danger_lms {
            background: #dc3545;
        }

        .bg-teal_lms {
            background: #20c997;
        }

        /* Icons */
        .icon_lms {
            display: inline-block;
            font-size: 36px;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar.php'); ?>
            <div class="span9" id="content">

                <!-- Cards for Quick Metrics -->
                <div class="row text-center mb-4 custome">
                    <?php
                    $query_reg_teacher = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_status = 'Registered'") or die(mysqli_error());
                    $count_reg_teacher = mysqli_num_rows($query_reg_teacher);

                    $query_teacher = mysqli_query($conn, "SELECT * FROM teacher") or die(mysqli_error());
                    $count_teacher = mysqli_num_rows($query_teacher);

                    $query_student_registered = mysqli_query($conn, "SELECT * FROM student WHERE status = 'Registered'") or die(mysqli_error());
                    $count_student_registered = mysqli_num_rows($query_student_registered);

                    $query_student = mysqli_query($conn, "SELECT * FROM student") or die(mysqli_error());
                    $count_student = mysqli_num_rows($query_student);

                    $query_class = mysqli_query($conn, "SELECT * FROM class") or die(mysqli_error());
                    $count_class = mysqli_num_rows($query_class);

                    $query_file = mysqli_query($conn, "SELECT * FROM files") or die(mysqli_error());
                    $count_file = mysqli_num_rows($query_file);

                    $query_subject = mysqli_query($conn, "SELECT * FROM subject") or die(mysqli_error());
                    $count_subject = mysqli_num_rows($query_subject);
                    ?>


                    <div class="dashboard-container">
                        <div class="row_lms">
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-primary_lms">📚</div>
                                <h5><?php echo $count_reg_teacher; ?></h5>
                                <p>Registered Teachers</p>
                            </div>
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-info_lms">👔</div>
                                <h5><?php echo $count_teacher; ?></h5>
                                <p>Total Teachers</p>
                            </div>
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-success_lms">🎓</div>
                                <h5><?php echo $count_student_registered; ?></h5>
                                <p>Registered Students</p>
                            </div>
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-warning_lms">👥</div>
                                <h5><?php echo $count_student; ?></h5>
                                <p>Total Students</p>
                            </div>
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-secondary_lms">🏫</div>
                                <h5><?php echo $count_class; ?></h5>
                                <p>Classes</p>
                            </div>
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-danger_lms">📥</div>
                                <h5><?php echo $count_file; ?></h5>
                                <p>Downloadable Files</p>
                            </div>
                            <div class="card_lms">
                                <div class="rounded-circle_lms bg-teal_lms">📘</div>
                                <h5><?php echo $count_subject; ?></h5>
                                <p>Subjects</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php'); ?>
        </div>
        <?php include('script.php'); ?>
</body>

</html>