<?php
@include '../functions/config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
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
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="eval.css">
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
            <li><a href="users.php">User</a></li>
            <li class="active"><a href="evaluate.php">Evaluate</a>
            <li><a href="status.php">Status</a></li><br><br><br><br><br><br><br>
           
            <a href="../home.php" button="" class="appealing-button3">Sign Out</a>
        </ul>
    </div>
    <div id="content">

        <div class="evaluate-container">
            <!-- Dashboard content goes here -->
            <br> <br> <br><a href = "eval.php" button class="appealing-button">Evaluate Now</button></a><br><br><br>
            <br> <a href = "../admin/adminprofile.php" button class="appealing-button2">Exit</button></a>

            

    </div>

</body>
</html>