<?php
include('header.php');
// include('session.php');

// Validate user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>alert('Invalid user ID!'); window.location='admin_user.php';</script>";
  exit;
}

$get_id = intval($_GET['id']);
?>

<body>
  <?php include('navbar.php'); ?>
  <div class="container-fluid">
    <div class="row-fluid">
      <a href="admin_user.php" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Back to Users</a>
      <!-- Edit User Block -->
      <div class="block">
        <div class="navbar navbar-inner block-header">
          <div class="muted pull-left">Edit User</div>
        </div>
        <div class="block-content collapse in">
          <div class="span12">
            <?php
            // Fetch the user details
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $get_id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();

            if (!$row) {
              echo "<script>alert('User not found!'); window.location='admin_user.php';</script>";
              exit;
            }
            ?>
            <form method="post">
              <div class="control-group">
                <div class="controls">
                  <input class="input focused" value="<?php echo htmlspecialchars($row['firstname']); ?>"
                    name="firstname" type="text" placeholder="Firstname" required>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <input class="input focused" value="<?php echo htmlspecialchars($row['lastname']); ?>" name="lastname"
                    type="text" placeholder="Lastname" required>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <input class="input focused" value="<?php echo htmlspecialchars($row['username']); ?>" name="username"
                    type="text" placeholder="Username" required>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <input class="input focused" name="password" type="password"
                    placeholder="New Password (leave blank if unchanged)">
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button name="update" class="btn btn-success"><i class="icon-save icon-large"></i> Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /block -->
    </div>
  </div>

  <?php
  if (isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Update query
    if (!empty($password)) {
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);
      $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, username = ?, password = ? WHERE user_id = ?");
      $stmt->bind_param("ssssi", $firstname, $lastname, $username, $password, $get_id);
    } else {
      $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, username = ? WHERE user_id = ?");
      $stmt->bind_param("sssi", $firstname, $lastname, $username, $get_id);
    }

    if ($stmt->execute()) {
      // Log activity
      $stmt = $conn->prepare("INSERT INTO activity_log (date, username, action) VALUES (NOW(), ?, ?)");
      $action = "Updated user " . htmlspecialchars($username);
      $stmt->bind_param("ss", $user_username, $action);
      $stmt->execute();

      echo "<script>alert('User updated successfully!'); window.location='admin_user.php';</script>";
    } else {
      echo "<script>alert('Error updating user!');</script>";
    }
  }
  ?>
</body>

</html>