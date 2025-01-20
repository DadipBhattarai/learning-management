<?php
include('dbcon.php');

if (isset($_POST['delete_teacher'])) {
    if (!empty($_POST['selector'])) {  // Check if selector is set
        $id = $_POST['selector'];
        $N = count($id);

        for ($i = 0; $i < $N; $i++) {
            $teacher_id = mysqli_real_escape_string($conn, $id[$i]);
            $result = mysqli_query($conn, "DELETE FROM teacher WHERE teacher_id='$teacher_id'");
        }
        header("location: teachers.php");
    } else {
        echo "<script>alert('No teacher selected!'); window.location.href='teachers.php';</script>";
    }
}
?>



<?php
// include('dbcon.php');

// if (isset($_POST['delete_teacher'])) {
//     if (!empty($_POST['selector'])) {  // Check if selector is set
//         $id = $_POST['selector'];
//         $N = count($id);

//         for ($i = 0; $i < $N; $i++) {
//             $teacher_id = mysqli_real_escape_string($conn, $id[$i]);
//             $result = mysqli_query($conn, "DELETE FROM teacher WHERE teacher_id='$teacher_id'");
//         }
//         header("location: teachers.php");
//     } else {
//         echo "<script>alert('No teacher selected!'); window.location.href='teachers.php';</script>";
//     }
// }
?>