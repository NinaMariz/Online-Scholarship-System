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
    <title>Edit Student Records</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div id="content">
        <div class="user-container">
            <h3>Edit Student Records</h3>
            <?php if ($studentRecordsResult && $studentRecordsResult->num_rows > 0) : ?>
                <table border="1">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>School</th>
                        <th>Program</th>
                        <th>Contact Number</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($record = $studentRecordsResult->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $record['Name']; ?></td>
                            <td><?php echo $record['Address']; ?></td>
                            <td><?php echo $record['School']; ?></td>
                            <td><?php echo $record['Program']; ?></td>
                            <td><?php echo $record['ContactNumber']; ?></td>
                            <td>
                                <a href='edit_record_process.php?id=<?php echo $record['ExistingTableID']; ?>'>Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else : ?>
                <p>No student records found.</p>
            <?php endif; ?>
            <a href='scholar2.php'>Add New Record</a>
        </div>
    </div>
</body>
</html>
