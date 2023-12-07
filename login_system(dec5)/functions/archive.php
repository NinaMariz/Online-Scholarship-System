<?php
@include 'config.php';

if (isset($_GET['id'])) {
    $userId = mysqli_real_escape_string($conn, $_GET['id']);

    // Update the user_type to 'archived' (or any other value you want to use for archived users)
    $archiveQuery = "UPDATE user_form SET user_type = 'archived' WHERE id = '$userId'";
    $archiveResult = mysqli_query($conn, $archiveQuery);

    if ($archiveResult) {
        header("Location: ../admin/users.php"); // Redirect back to the users page after archiving
        exit();
    } else {
        echo "Error archiving user: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
