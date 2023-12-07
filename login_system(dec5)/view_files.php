<?php
@include 'functions/config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:part.php');
    exit();
}

// Fetch details of the logged-in user
$userName = $_SESSION['user_name'];
$userDetailsQuery = "SELECT * FROM user_form WHERE name = '$userName'";
$userDetailsResult = mysqli_query($conn, $userDetailsQuery);

// Check if the query was successful
if ($userDetailsResult) {
    $userDetails = mysqli_fetch_assoc($userDetailsResult);

    // Fetch records from user_files based on the user's ID
    $userId = $userDetails['id'];
    $userFilesQuery = "SELECT * FROM user_files WHERE user_id = '$userId'";
    $userFilesResult = mysqli_query($conn, $userFilesQuery);
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
    $userFilesResult = false; // Set result to false
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gabarito&family=Noto+Sans+Georgian:wght@700&display=swap" rel="stylesheet">
    <title>View Files</title>
</head>
<body>
    <nav>
        <!-- Your navigation code here -->
    </nav>

    <div class="view-files-page">
        <h2>View Uploaded Files</h2>

        <?php
        if ($userFilesResult) {
            while ($fileRow = mysqli_fetch_assoc($userFilesResult)) {
                echo "<div class='file-info'>";
                echo "<p>File 1: <a href='uploads/{$fileRow['file1']}' download>{$fileRow['file1']}</a> | <a href='edit.php?id={$fileRow['id']}&file=file1'>Edit</a></p>";
                echo "<p>File 2: <a href='uploads/{$fileRow['file2']}' download>{$fileRow['file2']}</a> | <a href='edit.php?id={$fileRow['id']}&file=file2'>Edit</a></p>";
                echo "<p>File 3: <a href='uploads/{$fileRow['file3']}' download>{$fileRow['file3']}</a> | <a href='edit.php?id={$fileRow['id']}&file=file3'>Edit</a></p>";
                echo "<p>File 4: <a href='uploads/{$fileRow['file4']}' download>{$fileRow['file4']}</a> | <a href='edit.php?id={$fileRow['id']}&file=file4'>Edit</a></p>";
                echo "<p>File 5: <a href='uploads/{$fileRow['file5']}' download>{$fileRow['file5']}</a> | <a href='edit.php?id={$fileRow['id']}&file=file5'>Edit</a></p>";
                echo "<p>File 6: <a href='uploads/{$fileRow['file6']}' download>{$fileRow['file6']}</a> | <a href='edit.php?id={$fileRow['id']}&file=file6'>Edit</a></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No files uploaded yet.</p>";
        }
        ?>
    </div>
</body>
</html>
