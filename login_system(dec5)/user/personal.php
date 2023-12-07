<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:part.php');
    exit();
}
$dsn = 'mysql:host=localhost;dbname=user_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if (!isset($_SESSION['user_name'])) {
    header('location:part.php');
    exit();
}

// Fetch details of the logged-in user
$userName = $_SESSION['user_name'];
$userDetailsQuery = "SELECT * FROM user_form WHERE name = '$userName'";
$userDetailsResult = $conn->query($userDetailsQuery);

if ($userDetailsResult) {
    $userDetails = $userDetailsResult->fetch(PDO::FETCH_ASSOC);
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $middleName = $_POST['MiddleName'];
    $suffix = $_POST['Suffix'];
    $birthdate = $_POST['Birthdate'];
    $birthplace = $_POST['Birthplace'];
    $age = $_POST['Age'];
    $sex = $_POST['Sex'];
    $street = $_POST['Street'];
    $barangay = $_POST['Barangay'];
    $city = $_POST['City'];
    $zipCode = $_POST['ZipCode'];
    $presentAddress = $_POST['PresentAddress'];
    $civilStatus = $_POST['CivilStatus'];
    $religion = $_POST['Religion'];
    $citizenship = $_POST['Citizenship'];
    $emailAddress = $_POST['EmailAddress'];
    $mobileNumber = $_POST['MobileNumber'];
    $guardianName = $_POST['GuardianName'];
    $guardianMobileNumber = $_POST['GuardianMobileNumber'];

    // Insert data into personal_table
    $insertQuery = "INSERT INTO personal_table (FirstName, LastName, MiddleName, Suffix, Birthdate, Birthplace, Age, Sex, Street, Barangay, City, ZipCode, PresentAddress, CivilStatus, Religion, Citizenship, EmailAddress, MobileNumber, GuardianName, GuardianMobileNumber, user_id) 
                    VALUES ('$firstName', '$lastName', '$middleName', '$suffix', '$birthdate', '$birthplace', '$age', '$sex', '$street', '$barangay', '$city', '$zipCode', '$presentAddress', '$civilStatus', '$religion', '$citizenship', '$emailAddress', '$mobileNumber', '$guardianName', '$guardianMobileNumber', '{$userDetails['id']}')";

    try {
        $conn->exec($insertQuery);
        // Redirect to a success page or perform other actions
        header('location: success.php');
        exit();
    } catch (PDOException $e) {
        die('Insertion failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        #content {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: -120px;
}

.user-container {
    text-align: left;
    margin: auto;
    width: 30%;
    padding: 20px;
}

.file-info {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px 0;
    }
    
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
<nav>
        <div class="left">
            <p><strong><i>Eto Batangueno Disiplinado!</i></strong></p>
        </div>
        <div class="center">
            <div class="logo-container">
                <img src="pics/mayor.png" alt="Logo 1">
                <img src="pics/seal.png" alt="Logo 2">
                <img src="pics/tayo.jpg" alt="Logo 3">
            </div>
        </div>
        <div class="right">
            <ul>
                <li><a href="user.php">Back to menu</a></li>
                <li><a href="#"></a></li>
            </ul>
    </nav>
    <!-- ... (existing HTML code) ... -->

    <!----- contents---->
    <div id="content">
        <div class="user-container">

        <form action="save.php" method="post">
        <!-- Personal Information -->
        <h2>Personal Information</h2>
        <label for="FirstName">First Name:</label>
        <input type="text" name="FirstName" required><br>

        <label for="LastName">Last Name:</label>
        <input type="text" name="LastName" required><br>

        <label for="MiddleName">Middle Name:</label>
        <input type="text" name="MiddleName"><br>

        <label for="Suffix">Suffix:</label>
        <input type="text" name="Suffix"><br>

        <label for="Birthdate">Birthdate:</label>
        <input type="date" name="Birthdate" required><br>

        <label for="Birthplace">Birthplace:</label>
        <input type="text" name="Birthplace" required><br>

        <label for="Age">Age:</label>
        <input type="number" name="Age" required><br>

        <label for="Sex">Sex:</label>
        <select name="Sex" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>

        <label for="Street">Street:</label>
        <input type="text" name="Street" required><br>

        <label for="Barangay">Barangay:</label>
        <input type="text" name="Barangay" required><br>

        <label for="City">City:</label>
        <input type="text" name="City" required><br>

        <label for="ZipCode">Zip Code:</label>
        <input type="text" name="ZipCode"><br>

        <label for="PresentAddress">Present Address:</label>
        <textarea name="PresentAddress" required></textarea><br>

        <label for="CivilStatus">Civil Status:</label>
        <select name="CivilStatus" required>
            <option value="single">Single</option>
            <option value="married">Married</option>
            <option value="divorced">Divorced</option>
            <option value="widowed">Widowed</option>
        </select><br>

        <label for="Religion">Religion:</label>
        <input type="text" name="Religion"><br>

        <label for="Citizenship">Citizenship:</label>
        <input type="text" name="Citizenship" required><br>

        <label for="EmailAddress">Email Address:</label>
        <input type="email" name="EmailAddress"><br>

        <label for="MobileNumber">Mobile Number:</label>
        <input type="text" name="MobileNumber" required><br>

        <label for="GuardianName">Guardian Name:</label>
        <input type="text" name="GuardianName"><br>

        <label for="GuardianMobileNumber">Guardian Mobile Number:</label>
        <input type="text" name="GuardianMobileNumber">
        <input type="submit" value="Submit"><br>

        </div>  
    </div>
</body>
</html>
