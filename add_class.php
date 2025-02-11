<?php
// Include database connection
include('dbcon.php'); // Ensure you have the correct connection file

if (!$conn) {
	die("Database connection failed: " . mysqli_connect_error());
}
?>

<!-- block -->
<div class="block">
	<div class="navbar navbar-inner block-header">
		<div id="" class="muted pull-left">
			<h4><i class="icon-plus-sign"></i> Add Class</h4>
		</div>
	</div>
	<div class="block-content collapse in">
		<div class="span12">
			<form method="post" id="add_class">
				<div class="control-group">
					<label>Class Name:</label>
					<div class="controls">
						<input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
						<select name="class_id" id="class_id" required>
							<option value="" disabled selected>Select Class</option>
							<?php
							$query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
							while ($row = mysqli_fetch_array($query)) {
								echo '<option value="' . $row['class_id'] . '">' . $row['class_name'] . '</option>';
							}
							?>
						</select>



					</div>
				</div>

				<div class="control-group">
					<label>Subject:</label>
					<div class="controls">
						<select name="subject_id" id="subject_id" required>
							<option value="" disabled selected>Select Subject</option>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label>School Year:</label>
					<div class="controls">
						<?php
						$query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year DESC LIMIT 1");
						if (!$query) {
							die("School Year Query Failed: " . mysqli_error($conn));
						}
						$row = mysqli_fetch_array($query);
						?>
						<input id="" class="span5" type="text" name="school_year"
							value="<?php echo isset($row['school_year']) ? $row['school_year'] : ''; ?>">
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button name="save" class="btn btn-success"><i class="icon-save"></i> Save</button>
					</div>
				</div>
			</form>

			<script>
				jQuery(document).ready(function ($) {
					$("#add_class").submit(function (e) {
						e.preventDefault();
						var _this = $(e.target);
						var formData = $(this).serialize();
						$.ajax({
							type: "POST",
							url: "add_class_action.php",
							data: formData,
							success: function (html) {
								if (html == "true") {
									$.jGrowl("Class Already Exists", { header: 'Add Class Failed' });
								} else {
									$.jGrowl("Class Successfully Added", { header: 'Class Added' });
									setTimeout(function () { window.location = 'dasboard_teacher.php'; }, 500);
								}
							}
						});
					});
				});
			</script>

		</div>
	</div>
</div>
<!-- /block -->

<script>
	$(document).ready(function () {
		$("#class_id").change(function () {
			var class_id = $(this).val(); // Get selected class_id

			$.ajax({
				type: "POST",
				url: "fetch_subjects.php",
				data: { class_id: class_id },
				success: function (data) {
					$("#subject_id").html(data); // Update subject dropdown
				},
				error: function (xhr, status, error) {
					console.error("AJAX Error: " + error); // Log AJAX errors
				}
			});
		});
	});
</script>