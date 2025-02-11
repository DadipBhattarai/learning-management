<?php
include('dbcon.php');

if (isset($_POST['un']) && isset($_POST['fn']) && isset($_POST['ln']) && isset($_POST['class_id'])) {
    $un = $_POST['un'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $email = $_POST['eml'];
    $class_id = $_POST['class_id'];

    // Check if the username already exists
    $check_query = mysqli_query($conn, "SELECT * FROM student WHERE username = '$un'");
    if (mysqli_num_rows($check_query) > 0) {
        // Username already exists
        echo json_encode(["status" => "error", "message" => "User ID already exists!"]);
    } else {
        // Insert new student
        $insert_query = mysqli_query($conn, "INSERT INTO student (username, firstname, lastname, email, location, class_id, status)
        VALUES ('$un', '$fn', '$ln', '$email', 'uploads/NO-IMAGE-AVAILABLE.jpg', '$class_id', 'Unregistered')") or die(mysqli_error($conn));

        echo json_encode(["status" => "success", "message" => "Student successfully added!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}
?>