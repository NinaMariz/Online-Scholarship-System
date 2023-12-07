<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get the logged-in user ID
$user_id = $_SESSION['user_id'];

// Connect to the database
$db = new mysqli('localhost', 'username', 'password', 'database_name');

// Query the user_form table to get the logged-in user's information
$user_query = "SELECT * FROM user_form WHERE id = $user_id";
$user_result = $db->query($user_query);

// Fetch the user information
$user_row = $user_result->fetch_assoc();

// Query the student_records table to get the logged-in user's student records
$student_query = "SELECT * FROM student_records WHERE ExistingTableID = $user_id";
$student_result = $db->query($student_query);

// Fetch all student records
$student_records = [];
while ($student_row = $student_result->fetch_assoc()) {
    $student_records[] = $student_row;
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged In Account</title>
</head>
<body>
    <h1>Logged In Account</h1>

    <p>Welcome, <?php echo $user_row['name']; ?>!</p>

    <h2>Your Student Records</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>School</th>
                <th>Program</th>
                <th>Email</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($student_records)): ?>
                <?php foreach ($student_records as $student_record): ?>
                    <tr>
                        <td><?php echo $student_record['Name']; ?></td>
                        <td><?php echo $student_record['Address']; ?></td>
                        <td><?php echo $student_record['School']; ?></td>
                        <td><?php echo $student_record['Program']; ?></td>
                        <td><?php echo $student_record['Email']; ?></td>
                        <td><?php echo $student_record['ContactNumber']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
