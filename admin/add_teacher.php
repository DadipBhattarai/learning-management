<div class="row-fluid">
  <!-- block -->
  <div class="block">
    <div class="navbar navbar-inner block-header">
      <div class="muted pull-left">Add Teacher</div>
    </div>
    <div class="block-content collapse in">
      <div class="span12">
        <?php
        // Initialize message and type variables
        $message = '';
        $messageType = ''; // success or warning
        
        if (isset($_POST['save'])) {
          $firstname = $_POST['firstname'];
          $lastname = $_POST['lastname'];
          $department_id = $_POST['department'];

          // Check if teacher already exists
          $stmt = $conn->prepare("SELECT * FROM teacher WHERE firstname = ? AND lastname = ?");
          $stmt->bind_param("ss", $firstname, $lastname);
          $stmt->execute();
          $result = $stmt->get_result();
          $count = $result->num_rows;
          $stmt->close();

          if ($count > 0) {
            // Teacher already exists
            $message = 'Teacher already exists!';
            $messageType = 'warning';
          } else {
            // Insert new teacher
            $stmt = $conn->prepare("INSERT INTO teacher (firstname, lastname, location, department_id) VALUES (?, ?, 'uploads/NO-IMAGE-AVAILABLE.jpg', ?)");
            $stmt->bind_param("ssi", $firstname, $lastname, $department_id);
            $stmt->execute();
            $stmt->close();

            // Success message
            $message = 'Teacher added successfully!';
            $messageType = 'success';
          }
        }
        ?>

        <!-- Form -->
        <form method="post">
          <div class="control-group">
            <label for="department">Department:</label>
            <div class="controls">
              <select name="department" id="department" class="form-control" required>
                <option value="" disabled selected>Select Department</option>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM department ORDER BY department_name");
                while ($row = mysqli_fetch_array($query)) {
                  echo '<option value="' . $row['department_id'] . '">' . $row['department_name'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label for="firstname">Firstname:</label>
            <div class="controls">
              <input class="form-control" name="firstname" id="firstname" type="text" placeholder="Enter Firstname"
                required>
            </div>
          </div>

          <div class="control-group">
            <label for="lastname">Lastname:</label>
            <div class="controls">
              <input class="form-control" name="lastname" id="lastname" type="text" placeholder="Enter Lastname"
                required>
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
              <button name="save" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Add Teacher</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /block -->
</div>

<!-- Toast Notification -->
<div id="toast-container" class="toast-container"></div>

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