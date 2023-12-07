<?php
@include '../functions/config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
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
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <style>
    table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        a button {
            text-decoration: none;
            color: white;
        }

        a button:hover {
            background-color: #45a049;
        }
        </style>
</head>
<body>
    <div id="sidebar">
        <header>
            <ul class="logo-list">
    
                <li class="logo-item"><img src="pics/seal.png" alt="Logo 1"></li>
                <li class="logo-item"><img src="pics/mayor.png" alt="Logo 2"></li>
                <li class="logo-item"><img src="pics/tayo.jpg" alt="Logo 3"></li>
               <div class ="bat"><strong><i> Eto Batangueno Disiplinado! </i> </strong> </div>
            </ul>
        </header>
        <div class="dashboard">
Admin dashboard
        </div>
        <ul class="nav-list">
            <li><a href="adminprofile.php">Admin profile</a></li>
            <li><a href="admin.php">User</a></li>
            <li class="active"><a href="evaluate.php">Evaluate</a>
            <li><a href="status.php">Status</a></li><br><br><br><br><br><br><br>
           
            <a href="../home.php" button="" class="appealing-button3">Sign Out</a>
        </ul>
    </div>
    <div id="content">

        <div class="user-container">
        <?php
        if (!empty($allUsers)) {
            echo "<table border='1'>";
            echo "<tr><th>User</th><th>Level</th><th>Action</th></tr>";

            foreach ($allUsers as $user) {
                // Only display users with specific types
                if (in_array($user['user_type'], ['hs', 'college', 'athlete'])) {
                    echo "<tr>";
                    echo "<td>{$user['name']}</td>";
                    echo "<td>{$user['user_type']}</td>";
                    echo "<td><a href='view_record1.php?id={$user['id']}'>View</a></td>"; // Adjust the URL as needed
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