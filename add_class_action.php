<?php
include('dbcon.php');

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve POST data
$session_id = mysqli_real_escape_string($conn, $_POST['session_id']);
$subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
$class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
$school_year = mysqli_real_escape_string($conn, $_POST['school_year']);

// Check if the class already exists
$query = mysqli_prepare($conn, "SELECT * FROM teacher_class WHERE subject_id = ? AND class_id = ? AND teacher_id = ? AND school_year = ?");
mysqli_stmt_bind_param($query, "iiis", $subject_id, $class_id, $session_id, $school_year);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$count = mysqli_num_rows($result);

if ($count > 0) {
    echo "true"; // Class already exists
} else {
    // Insert the new class
    $insert_query = mysqli_prepare($conn, "INSERT INTO teacher_class (teacher_id, subject_id, class_id, thumbnails, school_year) VALUES (?, ?, ?, ?, ?)");
    $thumbnail = 'admin/uploads/thumbnails.jpg'; // String
    mysqli_stmt_bind_param($insert_query, "iiiss", $session_id, $subject_id, $class_id, $thumbnail, $school_year);

    if (mysqli_stmt_execute($insert_query)) {
        $teacher_class_id = mysqli_insert_id($conn); // Get last inserted ID

        // Fetch students from the class
        $student_query = mysqli_prepare($conn, "SELECT student_id FROM student WHERE class_id = ?");
        mysqli_stmt_bind_param($student_query, "i", $class_id);
        mysqli_stmt_execute($student_query);
        $student_result = mysqli_stmt_get_result($student_query);

        if (mysqli_num_rows($student_result) > 0) {
            while ($row = mysqli_fetch_assoc($student_result)) {
                $student_id = $row['student_id'];

                // Insert into teacher_class_student table
                $insert_student = mysqli_prepare($conn, "INSERT INTO teacher_class_student (teacher_id, student_id, teacher_class_id) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($insert_student, "iii", $session_id, $student_id, $teacher_class_id);
                mysqli_stmt_execute($insert_student);
            }
        }
        echo "yes"; // Successfully added class and students
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close connections
mysqli_stmt_close($query);
mysqli_stmt_close($insert_query);
mysqli_stmt_close($student_query);
mysqli_close($conn);
?>