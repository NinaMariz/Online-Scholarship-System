<?php
@include '../functions/config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:part.php');
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

<!DOCTYPE html>
<html>
<head>
    <title>Status User</title>
    <!-- Add your stylesheets and other head content here -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>

button {
    padding: 8px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

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
                <div class="bat"><strong><i>Eto Batangueno Disiplinado!</i></strong></div>
            </ul>
        </header>
        <div class="dashboard">
            Admin dashboard
        </div>
        <ul class="nav-list">
            <li><a href="adminprofile.php">Admin Profile</a></li>
            <li><a href="users.php">User</a></li>
            <li><a href="evaluate.php">Evaluate</a></li>
            <li class="active"><a href="status.php">Status</a></li><br><br><br><br><br><br><br>
           
            <a href="../home.php"><button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>
    <div id="content">

        <div class="user-container">
    <h1>User Records</h1>
    <?php
    // Check if status parameter is set
    if (isset($_GET['status'])) {
        $status = mysqli_real_escape_string($conn, $_GET['status']);
        $query = "SELECT * FROM student_records WHERE status = '$status'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Display user records based on the selected status
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['ExistingTableID'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "Error fetching user records: " . mysqli_error($conn);
        }
    } else {
        echo "Status parameter is not set.";
    }
    ?>
</body>
</html>