<?php
include('admin/dbcon.php');
include('session.php');

if (isset($_POST['read']) && isset($_POST['selector']) && !empty($_POST['selector'])) {
	$id = $_POST['selector']; // Array of selected notification IDs
	$N = count($id); // Get the count of selected notifications

	for ($i = 0; $i < $N; $i++) {
		// Insert into notification_read table
		mysqli_query($conn, "INSERT INTO notification_read (student_id, student_read, notification_id) VALUES('$session_id', 'yes', '$id[$i]')") or die(mysqli_error($conn));
	}

	// Redirect after updating
	?>
	<script>
		window.location = 'student_notification.php';
	</script>
	<?php
} else {
	// If no notifications were selected
	echo '<script>alert("Please select at least one notification to mark as read."); window.location="student_notification.php";</script>';
}
?>