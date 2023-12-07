<?php
@include '../functions/config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:../part.php');
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
Admin dashboard
        </div>
        <ul class="nav-list">
            <li><a href="studentrecord.html">Student Record</a></li>
            </a><li class="active"><a href="user.html">User</a></li>
            <li><a href="evaluate.html">Evaluate</a></li><br><br><br><br><br><br><br>
           
            <a href= "home.php" button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>
    <div id="content">

        <div class="user-container">
            <!-- Dashboard content goes here -->
            <h1>User's Profile</h1>
        <div class="search-container">
            <input type="text" placeholder="Search...">
            <button type="button">Search</button>
        </div>


        <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
include '../functions/config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Attempt to fetch user details based on the provided ID
    $query = "SELECT * FROM user_form WHERE id = $userId";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Display an edit form
            echo "<form method='POST' action='update.php'>";
            echo "<input type='hidden' name='id' value='{$user['id']}'>";
            echo "<input type='text' name='name' value='{$user['name']}'>";
            echo "<input type='text' name='email' value='{$user['email']}'>";
            echo "<input type='password' name='password' placeholder='New Password'>";
            echo "<input type='text' name='user_type' value='{$user['user_type']}'>";
            echo "<input type='submit' value='Update'>";
            echo "</form>";
        } else {
            echo "User not found";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_free_result($result);
}

mysqli_close($conn);
?>


    </div>
</body>
</html>




