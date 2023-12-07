<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:part.php');
   exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $school = $_POST['school'];
    $program = $_POST['program'];
    $contactNumber = $_POST['contactNumber'];

    // Update the record in the database
    $updateQuery = "UPDATE student_records 
                    SET Name = '$name', Address = '$address', School = '$school', Program = '$program', ContactNumber = '$contactNumber' 
                    WHERE ExistingTableID";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "Record updated successfully!";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
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

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student Record</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div id="content">
        <div class="user-container">
            <h3>Edit Student Record</h3>
            <?php if ($studentRecordsResult && $studentRecordsResult->num_rows > 0) : ?>
                <form action="editRecord.php" method="post">
                    <?php while ($record = $studentRecordsResult->fetch_assoc()) : ?>
                        <?php echo $record['ExistingTableID']; ?><br>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $record['Name']; ?>" required><br>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo $record['Address']; ?>" required><br>

                        <label for="school">School:</label>
                        <input type="text" id="school" name="school" value="<?php echo $record['School']; ?>" required><br>

                        <label for="program">Program:</label>
                        <input type="text" id="program" name="program" value="<?php echo $record['Program']; ?>" required><br>

                        <label for="contactNumber">Contact Number:</label>
                        <input type="tel" id="contactNumber" name="contactNumber" value="<?php echo $record['ContactNumber']; ?>" required><br>

                        <input type="submit" value="Update Record">
                    <?php endwhile; ?>
                </form>
            <?php else : ?>
                <p>No student records found.</p>
            <?php endif; ?>
            <a href='user.php'>Go back</a>
        </div>
    </div>
</body>
</html>
