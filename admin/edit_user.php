<?php
include('header.php');
include('session.php');

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<body>
	<?php include('navbar.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('sidebar.php'); ?>
			<div class="span3" id="adduser">
				<?php include('edit_user_form.php'); ?>
			</div>
			<div class="span6">
				<div class="row-fluid">
					<!-- User List Block -->
					<div id="block_bg" class="block">
						<div class="navbar navbar-inner block-header">
							<div class="muted pull-left">Admin Users List</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<form action="delete_users.php" method="post">
									<input type="hidden" name="csrf_token"
										value="<?php echo $_SESSION['csrf_token']; ?>">
									<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
										<a data-toggle="modal" href="#user_delete" id="delete" class="btn btn-danger"
											name=""><i class="icon-trash icon-large"></i></a>
										<?php include('modal_delete.php'); ?>
										<thead>
											<tr>
												<th>Select</th>
												<th>Name</th>
												<th>Username</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$stmt = $conn->prepare("SELECT * FROM users");
											$stmt->execute();
											$result = $stmt->get_result();

											while ($row = $result->fetch_assoc()) {
												$id = $row['user_id'];
												?>
												<tr>
													<td>
														<input id="optionsCheckbox" class="uniform_on" name="selector[]"
															type="checkbox" value="<?php echo $id; ?>">
													</td>
													<td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
													</td>
													<td><?php echo htmlspecialchars($row['username']); ?></td>
													<td>
														<a href="edit_user.php?id=<?php echo $id; ?>"
															class="btn btn-success">
															<i class="icon-pencil icon-large"></i> Edit
														</a>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</form>
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