<form id="signup_teacher" class="form-signin" method="post">
	<h3 class="form-signin-heading">
		<i class="icon-lock"></i> Sign up as Teacher
	</h3>
	<input type="text" class="input-block-level" name="firstname" placeholder="Firstname" required>
	<input type="text" class="input-block-level" name="lastname" placeholder="Lastname" required>

	<label for="department_id">Department</label>
	<select name="department_id" id="department_id" class="input-block-level span12" required>
		<option value="" disabled selected>Select Department</option>
		<?php
		$query = mysqli_query($conn, "SELECT * FROM department ORDER BY department_name") or die(mysqli_error($conn));
		while ($row = mysqli_fetch_assoc($query)) {
			echo '<option value="' . $row['department_id'] . '">' . htmlspecialchars($row['department_name'], ENT_QUOTES, 'UTF-8') . '</option>';
		}
		?>
	</select>

	<input type="text" class="input-block-level" name="username" placeholder="Username" required>
	<input type="password" class="input-block-level" name="password" id="password" placeholder="Password" required>
	<input type="password" class="input-block-level" name="cpassword" id="cpassword" placeholder="Re-type Password"
		required>

	<button id="signup" class="btn btn-info" type="submit">
		<i class="icon-check icon-large"></i> Sign Up
	</button>
</form>

<script>
	$(document).ready(function () {
		$('#signup_teacher').on('submit', function (e) {
			e.preventDefault();

			const password = $('#password').val();
			const cpassword = $('#cpassword').val();

			if (password === cpassword) {
				$.ajax({
					type: 'POST',
					url: 'teacher_signup.php',
					data: $(this).serialize(),
					success: function (response) {
						if (response.trim() === 'true') {
							$.jGrowl('Welcome to Xemon Learning Management System', { header: 'Sign Up Success' });
							setTimeout(() => { window.location = 'dasboard_teacher.php' }, 1000);
						} else {
							$.jGrowl('Sign up failed. Please try again.', { header: 'Sign Up Failed' });
						}
					},
					error: function () {
						$.jGrowl('An error occurred. Please try again.', { header: 'Error' });
					}
				});
			} else {
				$.jGrowl('Passwords do not match. Please try again.', { header: 'Sign Up Failed' });
			}
		});
	});
</script>

<a href="index.php" class="btn">
	<i class="icon-signin icon-large"></i> Click here to Login
</a>