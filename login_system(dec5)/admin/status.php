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

<?php
// Assume you have a connection in config.php
@include '../functions/config.php';

// Count the number of 'accepted', 'deficiency', and 'reject' statuses
$countQuery = "SELECT 
    SUM(CASE WHEN status = 'approve' THEN 1 ELSE 0 END) AS accepted_count,
    SUM(CASE WHEN status = 'deficiency' THEN 1 ELSE 0 END) AS deficiency_count,
    SUM(CASE WHEN status = 'reject' THEN 1 ELSE 0 END) AS reject_count
FROM student_records";
$countResult = mysqli_query($conn, $countQuery);

if ($countResult) {
    $countData = mysqli_fetch_assoc($countResult);
    $acceptedCount = $countData['accepted_count'];
    $deficiencyCount = $countData['deficiency_count'];
    $rejectCount = $countData['reject_count'];
} else {
    // Handle error if needed
    $acceptedCount = 0;
    $deficiencyCount = 0;
    $rejectCount = 0;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
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
        <h2>Status Counts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Accepted</td>
                        <td><?php echo $acceptedCount; ?></td>
                        <td><a href="statususer.php?status=approve">View Users</a></td>
                    </tr>
                    <tr>
                        <td>Deficiency</td>
                        <td><?php echo $deficiencyCount; ?></td>
                        <td><a href="statususer.php?status=deficiency">View Users</a></td>
                    </tr>
                    <tr>
                        <td>Reject</td>
                        <td><?php echo $rejectCount; ?></td>
                        <td><a href="statususer.php?status=reject">View Users</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ... (rest of the HTML code) ... -->
</body>

</html>
