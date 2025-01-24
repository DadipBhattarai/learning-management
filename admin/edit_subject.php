<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
	<?php include('navbar.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('sidebar.php'); ?>

			<div class="span9" id="content">
				<div class="row-fluid">
					<a href="add_subject.php" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Add
						Subject</a>
					<!-- block -->
					<div id="" class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Edit Subject</div>
						</div>
						<div class="block-content collapse in">
							<a href="subjects.php"><i class="icon-arrow-left"></i> Back</a>

							<?php
							$query = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id = '$get_id'") or die(mysqli_error());
							$row = mysqli_fetch_array($query);

							// Check if $row is empty and handle it
							if (!$row) {
								echo "<script>alert('No subject found with the given ID.'); window.location = 'subjects.php';</script>";
								exit();
							}
							?>

							<form class="form-horizontal" method="post">
								<div class="control-group">
									<label class="control-label" for="inputEmail">Subject Code</label>
									<div class="controls">
										<input type="text" value="<?php echo $row['subject_code']; ?>"
											name="subject_code" id="inputEmail" placeholder="Subject Code">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Subject Title</label>
									<div class="controls">
										<input type="text" value="<?php echo $row['subject_title']; ?>" class="span8"
											name="title" id="inputPassword" placeholder="Subject Title" required>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Number of Units</label>
									<div class="controls">
										<input type="text" value="<?php echo $row['unit']; ?>" class="span1" name="unit"
											id="inputPassword" required>
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="semester">Semester</label>
									<div class="controls">
										<select name="semester" id="semester">
											<option value="" disabled>Select Semester</option>
											<?php
											$semesterQuery = mysqli_query($conn, "SELECT DISTINCT class_name FROM class") or die(mysqli_error($conn));

											if (mysqli_num_rows($semesterQuery) > 0) {
												while ($row2 = mysqli_fetch_assoc($semesterQuery)) {
													// Check if the semester is selected
													$selected = ($row2['class_name'] == $row['semester']) ? 'selected' : '';
													echo "<option value='" . htmlspecialchars($row2['class_name']) . "' $selected>" . htmlspecialchars($row2['class_name']) . "</option>";
												}
											} else {
												echo "<option value='' disabled>No semesters available</option>";
											}
											?>
										</select>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="inputPassword">Description</label>
									<div class="controls">
										<textarea name="description"
											id="ckeditor_full"><?php echo htmlspecialchars(trim($row['description'])); ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<button name="update" type="submit" class="btn btn-info"><i
												class="icon-save icon-large"></i> Update</button>
									</div>
								</div>
							</form>

							<?php
							if (isset($_POST['update'])) {
								$subject_code = $_POST['subject_code'];
								$title = $_POST['title'];
								$unit = $_POST['unit'];
								$description = $_POST['description'];
								$semester = $_POST['semester'];

								mysqli_query($conn, "UPDATE subject SET subject_code = '$subject_code', subject_title = '$title', unit = '$unit', description = '$description', semester = '$semester' WHERE subject_id = '$get_id'") or die(mysqli_error());

								mysqli_query($conn, "INSERT INTO activity_log (date,username,action) VALUES(NOW(),'$user_username','Edit Subject $subject_code')") or die(mysqli_error());
								?>

								<script>
									window.location = "subjects.php";
								</script>
								<?php
							}
							?>
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