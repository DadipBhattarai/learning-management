<?php include('header.php'); ?>
<style>
	body#login {
		background: #f5f5f5;
	}

	.container {
		max-width: 400px;
		margin-top: 80px;
		background: #fff;
		padding: 30px;
		border-radius: 10px;
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
		text-align: center;
	}

	.form-signin-heading {
		font-size: 22px;
		margin-bottom: 20px;
		color: #333;
	}

	.input-block-level {
		width: 100%;
		padding: 10px;
		margin-bottom: 10px;
		border: 1px solid #ddd;
		border-radius: 5px;
	}

	.btn-info {
		width: 100%;
		padding: 10px;
		font-size: 16px;
		border-radius: 5px;
	}
</style>

<body id="login">
	<div class="container">
		<form id="login_form" class="form-signin" method="post">
			<h3 class="form-signin-heading"><i class="icon-lock"></i> Please Login</h3>
			<input type="text" class="input-block-level" id="username" name="username" placeholder="Username" required>
			<input type="password" class="input-block-level" id="password" name="password" placeholder="Password"
				required>
			<button name="login" class="btn btn-info" type="submit"><i class="icon-signin"></i> Sign in</button>
		</form>
	</div>
	<script>
		jQuery(document).ready(function () {
			jQuery("#login_form").submit(function (e) {
				e.preventDefault();
				var formData = jQuery(this).serialize();
				$.ajax({
					type: "POST",
					url: "login.php",
					data: formData,
					success: function (html) {
						if (html == 'true') {
							$.jGrowl("Welcome to Xemon Learning Management System", { header: 'Access Granted' });
							setTimeout(function () { window.location = 'dashboard.php'; }, 1000);
						} else {
							$.jGrowl("Please check your username and password", { header: 'Login Failed' });
						}
					}
				});
				return false;
			});
		});
	</script>
	<?php include('script.php'); ?>
</body>

</html>