<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
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
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $school = $_POST['school'];
    $program = $_POST['program'];
    $contactNumber = $_POST['contactNumber'];

    // Insert data into the database
    $insertQuery = "INSERT INTO student_records (ExistingTableID, name, address, school, program, contactNumber) 
                    VALUES ('{$userDetails['id']}', '$name', '$address', '$school', '$program', '$contactNumber')";
    
    if (mysqli_query($conn, $insertQuery)) {
        echo "Form submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<a href='user.php'>return</a>