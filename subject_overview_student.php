<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
	<?php include('navbar_student.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('subject_overview_link_student.php'); ?>
			<div class="span9" id="content">
				<div class="row-fluid">
					<!-- breadcrumb -->

					<?php
					$class_query = mysqli_query($conn, "SELECT * FROM teacher_class
                                                        LEFT JOIN class ON class.class_id = teacher_class.class_id
                                                        LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                                        WHERE teacher_class_id = '$get_id'") or die(mysqli_error());
					$class_row = mysqli_fetch_array($class_query);
					?>

					<ul class="breadcrumb">
						<li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
						<li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span>
						</li>
						<li><a href="#"><b>Subject Overview</b></a></li>
					</ul>
					<!-- end breadcrumb -->

					<!-- block -->
					<div id="block_bg" class="block">
						<div class="navbar navbar-inner block-header">
							<div id="" class="muted pull-left"></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">

								<?php
								// Query to fetch the class details and instructor information
								$query = mysqli_query($conn, "SELECT * FROM teacher_class
                                                              LEFT JOIN class ON class.class_id = teacher_class.class_id
                                                              LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                                              LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
                                                              WHERE teacher_class_id = '$get_id'") or die(mysqli_error());
								$row = mysqli_fetch_array($query);
								$id = $row['teacher_class_id'];

								?>

								<strong>Instructor: <?php echo $row['firstname']; ?>
									<?php echo $row['lastname']; ?></strong>
								<br>
								<img id="avatar" class="img-polaroid" src="admin/<?php echo $row['location']; ?>" width>
								<p><a href=""><i class="icon-search"></i> view info</a></p>
								<hr>

								<?php
								// Query to fetch the subject overview content
								$query = mysqli_query($conn, "SELECT * FROM teacher_class
                                                              LEFT JOIN class_subject_overview ON class_subject_overview.teacher_class_id = teacher_class.teacher_class_id
                                                              WHERE class_subject_overview.teacher_class_id = '$get_id'") or die(mysqli_error());
								$row_subject = mysqli_fetch_array($query);

								// Check if the result exists before trying to access the 'content' field
								if ($row_subject) {
									echo $row_subject['content'];  // Display the content if it exists
								} else {
									echo "<p>No subject overview available.</p>";  // Display a message if no content found
								}
								?>
							</div>
						</div>
					</div>
					<!-- /block -->
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<?php include('script.php'); ?>
</body>

</html>