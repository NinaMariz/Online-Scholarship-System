<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header('location: part.php');
    exit();
}

// Include the database connection code
include 'config.php';

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
    $studentRecordsResult = mysqli_query($conn, $studentRecordsQuery);

    // Check if the query was successful
    if ($studentRecordsResult && mysqli_num_rows($studentRecordsResult) > 0) {
        // Set result to the result object
        $studentRecordsResultObj = $studentRecordsResult;
    } else {
        // Set result to false
        $studentRecordsResultObj = false;
    }
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
    $studentRecordsResultObj = false; // Set result to false
}

// Display a message based on the status
function getStatusMessage($status) {
    switch ($status) {
        case 'approve':
            return'APPROVED';
        case 'deficiency':
            return 'Some files are missing, please check your uploaded files.';
        case 'reject':
            return 'We regret to inform you that your application has been rejected.';
        default:
            return 'Unknown status';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        #content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 75vh;
    margin-left: 160px;
}

.user-container {
    text-align: center;
}

/* Additional styling for your content if needed */
.column {
    width: 80%;
    max-width: 600px;
    margin: 0 auto;
}

.record-container {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px 0;
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
            Hello <?php echo $_SESSION['user_name'] ?>!
        </div>
        <ul class="nav-list">
        <?php
@include 'config.php';



if(!isset($_SESSION['user_name'])){
   header('location:part.php');
   exit();
}

$userName = $_SESSION['user_name'];

if (isset($mysqli)) {
    $checkRecordQuery = "SELECT COUNT(*) FROM personal_table WHERE user_id = (SELECT id FROM user_form WHERE name = ?)";
    $checkRecordStmt = $mysqli->prepare($checkRecordQuery);
    
    // Bind the parameter
    $checkRecordStmt->bind_param('s', $userName);

    // Execute the query
    $checkRecordStmt->execute();

    // Bind the result variable
    $checkRecordStmt->bind_result($recordCount);

    // Fetch the result
    $checkRecordStmt->fetch();

    // ... (your existing code)
}

?>
            <li><a href="user.php">Scholar profile</a></li>

            <?php
        // Modify the link based on the user_type
        $newScholarLink = ($_SESSION['user_type'] === 'athlete') ? 'athlete_scholars.php' : 'personal.php';

        // Disable the link and show a message if a record already exists
        if ($_SESSION > 0) {
        } else {
            echo '<li><a href="' . $newScholarLink . '">New scholar?<br>Apply now</a></li>';
        }
        ?>

            <li><a href="myFiles.php">Renew application</a></li>
            <li><a href="myFiles.php">My files</a></li>
            <li class="active"><a href="notif.php">Notification</a></li><br><br><br><br><br><br><br>
            <a href="../home.php" button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>

    <div id="content">
        <div class="user-container">
            <?php if ($studentRecordsResultObj && mysqli_num_rows($studentRecordsResultObj) > 0) : ?>
                <div class="column">
                    <h3>Notification</h3>
                    <?php while ($record = mysqli_fetch_assoc($studentRecordsResultObj)) : ?>
                        <div class="record-container">
                            <span>Status:</span>
                                <?php echo $record['status']; ?>
                            <p><?php echo getStatusMessage($record['status']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No student records found.</p>
                <?php endif; ?>
                </div>
        </div>
    </div>
</body>

</html>
