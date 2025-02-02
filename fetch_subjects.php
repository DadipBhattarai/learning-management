<?php
include('dbcon.php');

if (isset($_POST['class_id'])) {
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);

    // Fetch subjects based on the selected class_id
    $query = mysqli_prepare($conn, "SELECT subject_id, subject_code, subject_title FROM subject 
                                    WHERE semester = (SELECT class_name FROM class WHERE class_id = ?) 
                                    ORDER BY subject_code");

    mysqli_stmt_bind_param($query, "i", $class_id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="" disabled selected>Select Subject</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['subject_code'] . ' - ' . $row['subject_title'] . '</option>';
        }
    } else {
        echo '<option disabled>No subjects available</option>';
    }

    mysqli_stmt_close($query);
}
?>