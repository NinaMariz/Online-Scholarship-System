<?php
@include 'functions/config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location: part.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_SESSION['user_name'];
    $userDetailsQuery = "SELECT * FROM user_form WHERE name = ?";
    $userDetailsStmt = mysqli_prepare($conn, $userDetailsQuery);

    if ($userDetailsStmt) {
        mysqli_stmt_bind_param($userDetailsStmt, "s", $userName);
        mysqli_stmt_execute($userDetailsStmt);
        $userDetailsResult = mysqli_stmt_get_result($userDetailsStmt);

        if ($userDetailsResult) {
            $userDetails = mysqli_fetch_assoc($userDetailsResult);
            $userId = $userDetails['id'];

            // Process file uploads and insert data into the database
            $uploadFolder = 'uploads/';

            $insertQuery = "INSERT INTO user_files (user_id, file1, file2, file3, file4, file5, file6) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);

            if ($insertStmt) {
                mysqli_stmt_bind_param($insertStmt, "sssssss", $userId, $file1, $file2, $file3, $file4, $file5, $file6);

                $file1 = $_FILES['file1']['name'];
                $file2 = $_FILES['file2']['name'];
                $file3 = $_FILES['file3']['name'];
                $file4 = $_FILES['file4']['name'];
                $file5 = $_FILES['file5']['name'];
                $file6 = $_FILES['file6']['name'];

                move_uploaded_file($_FILES['file1']['tmp_name'], $uploadFolder . $file1);
                move_uploaded_file($_FILES['file2']['tmp_name'], $uploadFolder . $file2);
                move_uploaded_file($_FILES['file3']['tmp_name'], $uploadFolder . $file3);
                move_uploaded_file($_FILES['file4']['tmp_name'], $uploadFolder . $file4);
                move_uploaded_file($_FILES['file5']['tmp_name'], $uploadFolder . $file5);
                move_uploaded_file($_FILES['file6']['tmp_name'], $uploadFolder . $file6);

                mysqli_stmt_execute($insertStmt);
                mysqli_stmt_close($insertStmt);

                // Redirect to a success page or do further processing
                header('location: success.php');
                exit();
            } else {
                // Handle the case where the insert statement preparation fails
                // Log or display an error message as needed
            }
        } else {
            // Handle the case where the query for user details fails
            $userDetails = array(); // Set empty details
            $studentRecordsResult = false; // Set result to false
        }

        mysqli_stmt_close($userDetailsStmt);
    } else {
        // Handle the case where the user details statement preparation fails
        // Log or display an error message as needed
    }
}
?>
