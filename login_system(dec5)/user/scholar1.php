<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
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

    // Fetch records from student_records based on the user's ID
    $userId = $userDetails['id'];
    $studentRecordsQuery = "SELECT * FROM student_records WHERE ExistingTableID = '$userId'";
    $studentRecordsResult = $conn->query($studentRecordsQuery);
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
    $studentRecordsResult = false; // Set result to false
}

?> 


<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
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
Hello <?php echo $_SESSION['user_name'] ?>!
        </div>
        <ul class="nav-list">
            <li class="active"><a href="scholar.php">Scholar profile</a></li>
            <li><a href="user.php">New scholar?<br>Apply now</a></li>
            <li><a href="evaluate.php">Renew application</a>
            <li><a href="evaluate.php">My files</a></li><br><br><br><br><br><br><br>
           
            <a href= "../home.php" button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>
    <div id="content">

        <div class="user-container">
        Hello <?php echo $_SESSION['user_name']; ?>!
            <!-- Display user details -->
            <p><strong>ID:</strong> <?php echo $userDetails['id']; ?></p>
            <p><strong>Email:</strong> <?php echo $userDetails['email']; ?></p>
            <!-- Include other user details as needed -->
            <a href ='scholar2.php'>Edit</a>
        </div>  
    </div>
</body>
</html>