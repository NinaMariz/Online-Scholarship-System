<?php
@include '../functions/config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:../part.php');
   exit();
}

// Fetch details of the logged-in user
$adminName = $_SESSION['admin_name'];
$userDetailsQuery = "SELECT * FROM user_form WHERE name = '$adminName'";
$userDetailsResult = mysqli_query($conn, $userDetailsQuery);

// Check if the query was successful
if ($userDetailsResult) {
    $userDetails = mysqli_fetch_assoc($userDetailsResult);

    // Fetch records from student_records based on the user's ID
    $userId = $userDetails['id'];
} 

?> 
<?php
include 'config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Delete associated records from student_records
    $deleteStudentRecordsQuery = "DELETE FROM student_records WHERE ExistingTableID = $userId";

    if (mysqli_query($conn, $deleteStudentRecordsQuery)) {
        echo "Associated records in student_records deleted successfully!";
    } else {
        echo "Error deleting associated records in student_records: " . mysqli_error($conn);
    }

    // Delete the user from the user_form table
    $deleteUserQuery = "DELETE FROM user_form WHERE id = $userId";

    if (mysqli_query($conn, $deleteUserQuery)) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

// Redirect back to the user list page after deletion
header("Location: ../admin/admin.php");
?>
