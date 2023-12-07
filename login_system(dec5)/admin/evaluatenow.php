<?php
@include '../functions/config.php';

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
            echo "<table border='1'>";
            echo "<tr><th>User</th><th>File 1</th><th>File 2</th><th>File 3</th><th>File 4</th><th>File 5</th><th>File 6</th><th>Timestamp</th><th>Action</th></tr>";

            foreach ($allUsers as $user) {
                // Only display users with specific types
                if (in_array($user['user_type'], ['hs', 'college', 'athlete'])) {
                    echo "<tr>";
                    echo "<td>{$user['name']}</td>";
                    if (!empty($user['files'])) {
                        foreach ($user['files'] as $fileField => $fileValue) {
                            // Exclude id and user_id columns
                            if ($fileField !== 'id' && $fileField !== 'user_id') {
                                echo "<td>";
                                if ($fileField === 'created_at') {
                                    // Format timestamp
                                    echo date('Y-m-d H:i:s', strtotime($fileValue));
                                } else {
                                    echo "<a href='../uploads/$fileValue' download>$fileValue</a>";
                                }
                                echo "</td>";
                            }
                        }
                    } else {
                        // If no files uploaded, display empty cells
                        for ($i = 0; $i < 6; $i++) {
                            echo "<td></td>";
                        }
                    }
                    echo "<td><a href='view_record.php?id={$user['id']}'>View</a></td>"; // Adjust the URL as needed
                    echo "</tr>";
                }
            }

            echo "</table>";
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </div>
</body>
</html>
