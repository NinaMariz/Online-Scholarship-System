<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location: part.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data (sanitize inputs to prevent SQL injection)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $school = mysqli_real_escape_string($conn, $_POST['school']);
    $program = mysqli_real_escape_string($conn, $_POST['program']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);

    // Fetch the user ID from the session
    $userId = $_SESSION['user_id'];

    // Check if the user ID is set
    if (!$userId) {
        echo "Error: User ID not found.";
        exit();
    }

    // Update the record in the database (use prepared statements to prevent SQL injection)
    $updateQuery = "UPDATE student_records 
                    SET Name = ?, Address = ?, School = ?, Program = ?, ContactNumber = ? 
                    WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sssssi', $name, $address, $school, $program, $contactNumber, $userId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Record updated successfully!";
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('location: user.php'); // Redirect to user.php after successful update
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
