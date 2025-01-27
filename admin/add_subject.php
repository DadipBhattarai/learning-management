<?php include('header.php'); ?>
<?php include('session.php'); ?>

<body>
	<?php include('navbar.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('sidebar.php'); ?>
			<div class="span9" id="content">
				<div class="row-fluid">
					<!-- block -->
					<div class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Add Subject</div>
						</div>
						<div class="block-content collapse in">
							<a href="subjects.php"><i class="icon-arrow-left"></i> Back</a>
							<form class="form-horizontal" method="post">
								<div class="control-group">
									<label class="control-label" for="subject_code">Subject Code</label>
									<div class="controls">
										<input type="text" name="subject_code" id="subject_code"
											placeholder="Subject Code" required>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="title">Subject Title</label>
									<div class="controls">
										<input type="text" class="span8" name="title" id="title"
											placeholder="Subject Title" required>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="unit">Number of Units</label>
									<div class="controls">
										<input type="number" class="span1" name="unit" id="unit" min="0" required>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="semester">Semester</label>
									<div class="controls">
										<select name="semester" id="semester" required>
											<option value="" disabled selected>Select Semester</option>
											<?php
											$semesterQuery = mysqli_query($conn, "SELECT DISTINCT class_name FROM class") or die(mysqli_error($conn));
											if (mysqli_num_rows($semesterQuery) > 0) {
												while ($row = mysqli_fetch_assoc($semesterQuery)) {
													echo "<option value='" . htmlspecialchars($row['class_name']) . "'>" . htmlspecialchars($row['class_name']) . "</option>";
												}
											} else {
												echo "<option value='' disabled>No semesters available</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="description">Description</label>
									<div class="controls">
										<textarea name="description" id="ckeditor_full"
											placeholder="Enter description here..." required></textarea>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<button name="save" type="submit" class="btn btn-info"><i class="icon-save"></i>
											Save</button>
									</div>
								</div>
							</form>

							<!-- PHP Logic for Toast Notification -->
							<?php
							$message = '';
							$messageType = '';

							if (isset($_POST['save'])) {
								// Sanitize user input
								$subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$unit = (int) $_POST['unit'];
								$description = mysqli_real_escape_string($conn, $_POST['description']);
								$semester = mysqli_real_escape_string($conn, $_POST['semester']);

								// Check if subject already exists
								$query = mysqli_prepare($conn, "SELECT * FROM subject WHERE subject_code = ?");
								mysqli_stmt_bind_param($query, "s", $subject_code);
								mysqli_stmt_execute($query);
								$result = mysqli_stmt_get_result($query);
								$count = mysqli_num_rows($result);

								if ($count > 0) {
									$message = 'Subject already exists!';
									$messageType = 'warning';
								} else {
									// Insert new subject
									$insertQuery = mysqli_prepare($conn, "INSERT INTO subject (subject_code, subject_title, description, unit, semester) VALUES (?, ?, ?, ?, ?)");
									mysqli_stmt_bind_param($insertQuery, "sssds", $subject_code, $title, $description, $unit, $semester);
									mysqli_stmt_execute($insertQuery);

									// Log activity
									$logQuery = mysqli_prepare($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), ?, ?)");
									$action = "Add Subject $subject_code";
									mysqli_stmt_bind_param($logQuery, "ss", $user_username, $action);
									mysqli_stmt_execute($logQuery);

									$message = 'Subject added successfully!';
									$messageType = 'success';
								}
							}
							?>

							<!-- Toast Notification Container -->
							<div id="toast-container" class="toast-container"></div>
						</div>
					</div>
					<!-- /block -->
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<?php include('script.php'); ?>

	<!-- CSS for Toast Notification -->
	<style>
		.toast-container {
			position: fixed;
			top: 20px;
			right: 20px;
			z-index: 9999;
		}

		.toast {
			display: flex;
			align-items: center;
			padding: 15px 20px;
			margin-bottom: 10px;
			border-radius: 8px;
			box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
			font-family: Arial, sans-serif;
			font-size: 14px;
			color: white;
			opacity: 0;
			animation: fadeInOut 5s ease;
			pointer-events: none;
		}

		.toast.success {
			background-color: #28a745;
		}

		.toast.warning {
			background-color: #ffc107;
		}

		@keyframes fadeInOut {
			0% {
				opacity: 0;
				transform: translateY(-20px);
			}

			10%,
			90% {
				opacity: 1;
				transform: translateY(0);
			}

			100% {
				opacity: 0;
				transform: translateY(-20px);
			}
		}
	</style>

	<!-- JavaScript for Toast Notification -->
	<script>
		function showNotification(type, message) {
			const container = document.getElementById('toast-container');

			// Create a new toast
			const toast = document.createElement('div');
			toast.classList.add('toast', type);
			toast.textContent = message;

			// Add toast to container
			container.appendChild(toast);

			// Remove toast after 5 seconds
			setTimeout(() => {
				toast.remove();
			}, 5000);
		}

		// Show notification if PHP message exists
		<?php if (!empty($message)) { ?>
			showNotification('<?php echo $messageType; ?>', '<?php echo $message; ?>');
		<?php } ?>
	</script>
</body>

</html>