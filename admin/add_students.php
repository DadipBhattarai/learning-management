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
			e.preventDefault(); // Prevent the form from submitting traditionally

			var _this = $(e.target); // Get the form that was submitted
			var formData = $(this).serialize(); // Serialize form data for submission

			$.ajax({
				type: "POST",
				url: "save_student.php", // Target script for saving student
				data: formData,
				success: function (response) {
					// Display success notification
					$.jGrowl("Student Successfully Added", { header: 'Student Added' });

					// Reload the student table dynamically
					$('#studentTableDiv').load('student_table.php', function (htmlResponse) {
						$("#studentTableDiv").html(htmlResponse);
						$('#example').dataTable({
							"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
							"sPaginationType": "bootstrap",
							"oLanguage": {
								"sLengthMenu": "_MENU_ records per page"
							}
						});

						// Clear form inputs after successful submission
						_this.find(":input").val('');
						_this.find('select option').attr('selected', false);
						_this.find('select option:first').attr('selected', true); // Set first option as selected
					});
				}
			});
		});
	});
</script>