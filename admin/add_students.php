<?php
include('dbcon.php'); // Include your database connection here

if (isset($_POST['save'])) {
	// Get form data
	$class_id = $_POST['class_id'];
	$id_number = $_POST['un'];
	$first_name = $_POST['fn'];
	$last_name = $_POST['ln'];

	// Check if the ID number already exists
	$query = mysqli_query($conn, "SELECT * FROM students WHERE id_number = '$id_number'");
	if (mysqli_num_rows($query) > 0) {
		// Return ID_EXISTS response for the front-end to handle
		echo 'ID_EXISTS';
	} else {
		// Insert student record into the database
		$insert_query = mysqli_query($conn, "INSERT INTO students (class_id, id_number, first_name, last_name) 
                                              VALUES ('$class_id', '$id_number', '$first_name', '$last_name')");
		if ($insert_query) {
			echo 'Success';
		} else {
			echo 'Error';
		}
	}
}
?>

<div class="row-fluid">
	<!-- block -->
	<div class="block">
		<div class="navbar navbar-inner block-header">
			<div class="muted pull-left">Add Student</div>
		</div>
		<div class="block-content collapse in">
			<div class="span12">
				<form id="add_student" method="post">
					<!-- Class Dropdown -->
					<div class="control-group">
						<label for="class_id">Class</label>
						<div class="controls">
							<select name="class_id" id="class_id" required>
								<option value="" disabled selected>Select Class</option>
								<?php
								$cys_query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
								while ($cys_row = mysqli_fetch_array($cys_query)) {
									echo "<option value='{$cys_row['class_id']}'>{$cys_row['class_name']}</option>";
								}
								?>
							</select>
						</div>
					</div>

					<!-- ID Number -->
					<div class="control-group">
						<label for="un">ID Number</label>
						<div class="controls">
							<input name="un" id="un" class="input focused" type="text" placeholder="ID Number" required>
						</div>
					</div>

					<!-- First Name -->
					<div class="control-group">
						<label for="fn">First Name</label>
						<div class="controls">
							<input name="fn" id="fn" class="input focused" type="text" placeholder="First Name"
								required>
						</div>
					</div>

					<!-- Last Name -->
					<div class="control-group">
						<label for="ln">Last Name</label>
						<div class="controls">
							<input name="ln" id="ln" class="input focused" type="text" placeholder="Last Name" required>
						</div>
					</div>

					<!-- Submit Button -->
					<div class="control-group">
						<div class="controls">
							<button type="submit" name="save" class="btn btn-info"><i
									class="icon-plus-sign icon-large"></i> Add Student</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /block -->
</div>

<script>
	jQuery(document).ready(function ($) {
		$("#add_student").submit(function (e) {
			e.preventDefault();
			var _this = $(e.target);
			var formData = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "save_student.php",
				data: formData,
				dataType: "json",
				success: function (response) {
					if (response.status === "error") {
						$.jGrowl(response.message, { header: 'Error' });
					} else if (response.status === "success") {
						$.jGrowl(response.message, { header: 'Student Added' });
						$('#studentTableDiv').load('student_table.php', function (response) {
							$("#studentTableDiv").html(response);
							$('#example').dataTable({
								"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
								"sPaginationType": "bootstrap",
								"oLanguage": {
									"sLengthMenu": "MENU records per page"
								}
							});
							$(_this).find(":input").val('');
							$(_this).find('select option').attr('selected', false);
							$(_this).find('select option:first').attr('selected', true);
						});
					}
				},
				error: function () {
					$.jGrowl("An error occurred while processing your request.", { header: 'Error' });
				}
			});
		});
	});
</script>