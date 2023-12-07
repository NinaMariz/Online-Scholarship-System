<?php
@include '../functions/config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:part.php');
    exit();
}

// Initialize variables
$userDetails = [];
$userFiles = [];
$selection = '';

// Process form submission
// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selection']) && isset($_GET['id'])) {
        $userId = $_GET['id'];
        $selection = $_POST['selection'];

        // Check if a record already exists for the user
        $existingRecordQuery = "SELECT * FROM student_records WHERE ExistingTableID = '$userId'";
        $existingRecordResult = mysqli_query($conn, $existingRecordQuery);

        if ($existingRecordResult && mysqli_num_rows($existingRecordResult) > 0) {
            // Update the existing record
            $updateSelectionQuery = "UPDATE student_records SET status = '$selection' WHERE ExistingTableID = '$userId'";
            mysqli_query($conn, $updateSelectionQuery);
        } else {
            // Insert a new record
            $insertSelectionQuery = "INSERT INTO student_records (ExistingTableID, status) VALUES ('$userId', '$selection')";
            mysqli_query($conn, $insertSelectionQuery);
        }

        // Free result set
        if ($existingRecordResult) {
            mysqli_free_result($existingRecordResult);
        }
    }
}

// Fetch user details
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details
    $userDetailsQuery = "SELECT * FROM user_form WHERE id = '$userId'";
    $userDetailsResult = mysqli_query($conn, $userDetailsQuery);

    if ($userDetailsResult) {
        $userDetails = mysqli_fetch_assoc($userDetailsResult);
    } else {
        // Handle the case where the query for user details fails
        $userDetails = array(); // Set empty details
    }

    // Fetch records from user_files based on the user's ID
    $userFilesQuery = "SELECT * FROM user_files WHERE user_id = '$userId'";
    $userFilesResult = mysqli_query($conn, $userFilesQuery);

    if ($userFilesResult) {
        $userFiles = mysqli_fetch_assoc($userFilesResult);
    } else {
        // Handle the case where the query for user files fails
        $userFiles = array(); // Set empty files
    }

    // Fetch status from student_records
    $statusQuery = "SELECT status FROM student_records WHERE ExistingTableID = '$userId'";
    $statusResult = mysqli_query($conn, $statusQuery);

    if ($statusResult) {
        $statusDetails = mysqli_fetch_assoc($statusResult);
        $selection = $statusDetails ? $statusDetails['status'] : ''; // Check if $statusDetails is not null
    } else {
        // Handle the case where the query for the status fails
        $selection = ''; // Set empty status
    }
} else {
    // Handle the case where the ID is not provided
    header('location: eval.php'); // Redirect to the page with the list of all users
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Your existing styles */
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
            <h2>View User Record</h2>

            <?php
            if (!empty($userDetails)) {
                echo "<p>User: {$userDetails['name']}</p>";
                if (!empty($userFiles)) {
                    echo "<p>Files:</p>";
                    echo "<ul>";
                    foreach ($userFiles as $fileField => $fileName) {
                        echo "<li>$fileField: <a href='../uploads/$fileName' download>$fileName</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No files uploaded for this user.</p>";
                }

                // Display the existing status
                if (!empty($selection)) {
                    echo "<p>Existing Status: $selection</p>";
                }

                // Add buttons to update the status
                echo "<form action='view_record1.php?id=$userId' method='post'>";
                echo "<label for='selection'>Update Status:</label>";
                echo "<button type='submit' name='selection' value='approve' " . ($selection == 'approve' ? 'style="background-color: #4CAF50; color: white;"' : '') . ">Approve</button>";
                echo "<button type='submit' name='selection' value='deficiency' " . ($selection == 'deficiency' ? 'style="background-color: #FF9800; color: white;"' : '') . ">Deficiency</button>";
                echo "<button type='submit' name='selection' value='reject' " . ($selection == 'reject' ? 'style="background-color: #f44336; color: white;"' : '') . ">Reject</button>";
                echo "</form>";
            } else {
                echo "<p>User not found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
