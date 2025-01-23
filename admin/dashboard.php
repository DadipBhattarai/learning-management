<?php include('header.php'); ?>
<?php include('session.php'); ?>

<head>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .row_lms {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
            gap: 20px;
        }

        .card_lms {
            flex: 1 1 calc(20% - 20px);
            /* 23% width with space for gaps */
            max-width: 20%;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
            background-color: #fff;
        }

        .card_lms h5 {
            margin: 10px 0;
            font-size: 24px;
            color: #333;
        }

        .card_lms p {
            margin: 5px 0;
            font-size: 14px;
            color: #777;
        }

        .rounded-circle_lms {
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
            font-size: 28px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Individual Colors for Icons */
        .bg-primary_lms {
            background-color: #007bff;
        }

        .bg-info_lms {
            background-color: #17a2b8;
        }

        .bg-success_lms {
            background-color: #28a745;
        }

        .bg-warning_lms {
            background-color: #ffc107;
        }

        .bg-secondary_lms {
            background-color: #6c757d;
        }

        .bg-danger_lms {
            background-color: #dc3545;
        }

        .bg-teal_lms {
            background-color: #20c997;
        }

        /* Custom Icons */
        .icon_lms {
            display: inline-block;
            font-weight: bold;
        }

        .icon-chalkboard-teacher_lms:before {
            content: "📚";
        }

        .icon-user-tie_lms:before {
            content: "👔";
        }

        .icon-user-graduate_lms:before {
            content: "🎓";
        }

        .icon-users_lms:before {
            content: "👥";
        }

        .icon-school_lms:before {
            content: "🏫";
        }

        .icon-file-download_lms:before {
            content: "📥";
        }

        .icon-book_lms:before {
            content: "📘";
        }
    </style>

    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar_dashboard.php'); ?>
            <div class="span9" id="content">

                <!-- Cards for Quick Metrics -->
                <div class="row text-center mb-4">
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


                    <div class="row_lms">
                        <!-- Registered Teachers -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-primary_lms">
                                <span class="icon_lms icon-chalkboard-teacher_lms"></span>
                            </div>
                            <h5><?php echo $count_reg_teacher; ?></h5>
                            <p>Registered Teachers</p>
                        </div>

                        <!-- Total Teachers -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-info_lms">
                                <span class="icon_lms icon-user-tie_lms"></span>
                            </div>
                            <h5><?php echo $count_teacher; ?></h5>
                            <p>Total Teachers</p>
                        </div>

                        <!-- Registered Students -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-success_lms">
                                <span class="icon_lms icon-user-graduate_lms"></span>
                            </div>
                            <h5><?php echo $count_student_registered; ?></h5>
                            <p>Registered Students</p>
                        </div>

                        <!-- Total Students -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-warning_lms">
                                <span class="icon_lms icon-users_lms"></span>
                            </div>
                            <h5><?php echo $count_student; ?></h5>
                            <p>Total Students</p>
                        </div>

                        <!-- Classes -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-secondary_lms">
                                <span class="icon_lms icon-school_lms"></span>
                            </div>
                            <h5><?php echo $count_class; ?></h5>
                            <p>Classes</p>
                        </div>

                        <!-- Downloadable Files -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-danger_lms">
                                <span class="icon_lms icon-file-download_lms"></span>
                            </div>
                            <h5><?php echo $count_file; ?></h5>
                            <p>Downloadable Files</p>
                        </div>

                        <!-- Subjects -->
                        <div class="card_lms">
                            <div class="rounded-circle_lms bg-teal_lms">
                                <span class="icon_lms icon-book_lms"></span>
                            </div>
                            <h5><?php echo $count_subject; ?></h5>
                            <p>Subjects</p>
                        </div>
                    </div>


                    <!-- Combined Chart Section -->
                    <div class="row mt-5">
                        <div class="col-md-12" style="width: 90%; max-width: 1000px; margin: 0 auto;">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <!-- Chart Container with Border and Shadow -->
                                    <div style="
                                    border: 2px solid #ccc; 
                                    border-radius: 10px; 
                                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
                                    padding: 10px; 
                                    background: #fff;">
                                        <canvas id="combinedChart" style="width: 100%; height: 400px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php'); ?>
        </div>
        <?php include('script.php'); ?>

        <!-- Chart.js Integration -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const combinedCtx = document.getElementById('combinedChart').getContext('2d');

            // Calculate the maximum value from the dataset and add 1 to determine the scale.
            const dataValues = [
                <?php echo $count_reg_teacher; ?>,
                <?php echo $count_teacher; ?>,
                <?php echo $count_student_registered; ?>,
                <?php echo $count_student; ?>,
                <?php echo $count_class; ?>,
                <?php echo $count_file; ?>,
                <?php echo $count_subject; ?>
            ];
            const maxValue = Math.max(...dataValues);
            const scaleMax = Math.ceil(maxValue + 1); // Add 1 to ensure the scale adjusts properly.

            new Chart(combinedCtx, {
                type: 'bar',
                data: {
                    labels: [
                        'Registered Teachers',
                        'Total Teachers',
                        'Registered Students',
                        'Total Students',
                        'Classes',
                        'Downloadable Files',
                        'Subjects'
                    ],
                    datasets: [{
                        label: 'Metrics Count',
                        data: dataValues,
                        backgroundColor: [
                            '#007bff', // Registered Teachers
                            '#17a2b8', // Total Teachers
                            '#28a745', // Registered Students
                            '#ffc107', // Total Students
                            '#6c757d', // Classes
                            '#dc3545', // Downloadable Files
                            '#20c997'  // Subjects
                        ],
                        borderColor: '#333', // Outer border color
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: scaleMax, // Set the maximum scale dynamically
                            ticks: {
                                stepSize: 1, // Step size for smaller gaps
                                padding: 5, // Reduce padding between the numbers and the gridlines
                                font: {
                                    size: 12 // Adjust font size for better appearance (optional)
                                }
                            },
                            grid: {
                                drawBorder: true, // Show axis border
                                borderColor: '#ccc', // Border color for the grid
                                color: '#eee' // Gridline color
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: true, // Show axis border
                                borderColor: '#ccc', // Border color for the grid
                                display: false // Hide horizontal gridlines
                            },
                            ticks: {
                                padding: 10 // Optional: Adjust padding for x-axis labels
                            }
                        }
                    }
                }
            });
        </script>
</body>

</html>