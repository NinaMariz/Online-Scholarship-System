<?php
@include 'functions/config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:part.php');
    exit();
}

// Fetch all users and their records
$allUsersQuery = "SELECT * FROM user_form";
$allUsersResult = mysqli_query($conn, $allUsersQuery);

if (!$allUsersResult) {
    // Handle the case where the query for all users fails
    $allUsers = array(); // Set empty array
} else {
    // Fetch records from user_files for each user
    $allUsers = array();
    while ($userRow = mysqli_fetch_assoc($allUsersResult)) {
        $userId = $userRow['id'];
        $userFilesQuery = "SELECT * FROM user_files WHERE user_id = '$userId'";
        $userFilesResult = mysqli_query($conn, $userFilesQuery);

        if ($userFilesResult) {
            $userRow['files'] = mysqli_fetch_assoc($userFilesResult);
        } else {
            // Handle the case where the query for user files fails
            $userRow['files'] = array(); // Set empty array
        }

        $allUsers[] = $userRow;
    }
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
    <title>All Users and Records</title>
</head>
<body>
    <nav>
        <!-- Your navigation code here -->
    </nav>

    <div class="all-users-page">
        <h2>All Users and Records</h2>

        <?php
        if (!empty($allUsers)) {
            foreach ($allUsers as $user) {
                echo "<div class='user-info'>";
                echo "<p>User: {$user['name']}</p>";
                if (!empty($user['files'])) {
                    echo "<p>Files:</p>";
                    echo "<ul>";
                    foreach ($user['files'] as $fileField => $fileName) {
                        echo "<li>$fileField: <a href='uploads/$fileName' download>$fileName</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No files uploaded for this user.</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </div>
</body>
</html>
