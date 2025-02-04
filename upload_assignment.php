<?php
include('session.php');
require("opener_db.php");

// Database connection
$conn = $connector->DbConnector();

$errmsg_arr = array();
$errflag = false;

$assignment_id = $_POST['id'];
$name = $_POST['name'];
$get_id = $_POST['get_id'];

// Function to sanitize values
function clean($str, $conn)
{
    $str = trim($str);
    return mysqli_real_escape_string($conn, stripslashes($str));
}

// Sanitize input
$filedesc = clean($_POST['desc'], $conn);

if (empty($filedesc)) {
    $errmsg_arr[] = "File description is missing";
    $errflag = true;
}

if ($_FILES['uploaded_file']['size'] >= (1048576 * 5)) {
    $errmsg_arr[] = "File exceeds the 5MB size limit";
    $errflag = true;
}

// If validation errors exist, redirect back
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    echo "<script>window.location = 'downloadable.php?id={$get_id}';</script>";
    exit();
}

// Generate a unique filename
$rd2 = mt_rand(1000, 9999) . "_File";

if (!empty($_FILES["uploaded_file"]) && $_FILES['uploaded_file']['error'] == 0) {
    $filename = basename($_FILES['uploaded_file']['name']);
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Block executable files
    if ($ext !== "exe" && $_FILES["uploaded_file"]["type"] !== "application/x-msdownload") {
        $newname = "admin/uploads/" . $rd2 . "_" . $filename;
        $name_notification = "Submitted Assignment: <b>{$name}</b>";

        // Check if the file already exists
        if (!file_exists($newname)) {
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname)) {
                // Insert assignment record using prepared statements
                $qry2 = $conn->prepare("INSERT INTO student_assignment (fdesc, floc, assignment_fdatein, fname, assignment_id, student_id) 
                                        VALUES (?, ?, NOW(), ?, ?, ?)");
                $qry2->bind_param("ssssi", $filedesc, $newname, $name, $assignment_id, $session_id);

                if ($qry2->execute()) {
                    // Notify teacher about submission
                    $notif_query = $conn->prepare("INSERT INTO teacher_notification (teacher_class_id, notification, date_of_notification, link, student_id, assignment_id) 
                                                   VALUES (?, ?, NOW(), 'view_submit_assignment.php', ?, ?)");
                    $notif_query->bind_param("issi", $get_id, $name_notification, $session_id, $assignment_id);
                    $notif_query->execute();

                    $_SESSION['SUCCESS_MSG'] = "Assignment uploaded successfully.";
                    echo "<script>window.location = 'downloadable.php?id={$get_id}';</script>";
                    exit();
                } else {
                    $errmsg_arr[] = "Database error: " . $conn->error;
                }
            } else {
                $errmsg_arr[] = "Error: File upload failed.";
            }
        } else {
            $errmsg_arr[] = "Error: File '{$filename}' already exists.";
        }
    } else {
        $errmsg_arr[] = "Error: Invalid file type. Executable files are not allowed.";
    }
} else {
    $errmsg_arr[] = "Error: No file uploaded.";
}

// Handle errors
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    echo "<script>window.location = 'downloadable.php?id={$get_id}';</script>";
    exit();
}

mysqli_close($conn);
?>