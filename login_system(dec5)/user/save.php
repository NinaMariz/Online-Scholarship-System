

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<style>
        #content {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: -120px;
}

.user-container {
    text-align: center;
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
<div id="content">
        <div class="user-container">
            
        <?php
include 'config.php';

$dsn = 'mysql:host=localhost;dbname=user_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:part.php');
    exit();
}

$userName = $_SESSION['user_name'];
$userDetailsQuery = "SELECT * FROM user_form WHERE name = :userName";
$userDetailsStmt = $pdo->prepare($userDetailsQuery);
$userDetailsStmt->bindParam(':userName', $userName, PDO::PARAM_STR);
$userDetailsStmt->execute();
$userDetails = $userDetailsStmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
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

    try {
        $insertQuery = "INSERT INTO personal_table (
            FirstName, LastName, MiddleName, Suffix, Birthdate, Birthplace, Age, Sex,
            Street, Barangay, City, ZipCode, PresentAddress, CivilStatus, Religion,
            Citizenship, EmailAddress, MobileNumber, GuardianName, GuardianMobileNumber, user_id
        ) VALUES (
            :firstName, :lastName, :middleName, :suffix, :birthdate, :birthplace, :age, :sex,
            :street, :barangay, :city, :zipCode, :presentAddress, :civilStatus, :religion,
            :citizenship, :emailAddress, :mobileNumber, :guardianName, :guardianMobileNumber, :userId
        )";

        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $insertStmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $insertStmt->bindParam(':middleName', $middleName, PDO::PARAM_STR);
        $insertStmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
        $insertStmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $insertStmt->bindParam(':birthplace', $birthplace, PDO::PARAM_STR);
        $insertStmt->bindParam(':age', $age, PDO::PARAM_INT);
        $insertStmt->bindParam(':sex', $sex, PDO::PARAM_STR);
        $insertStmt->bindParam(':street', $street, PDO::PARAM_STR);
        $insertStmt->bindParam(':barangay', $barangay, PDO::PARAM_STR);
        $insertStmt->bindParam(':city', $city, PDO::PARAM_STR);
        $insertStmt->bindParam(':zipCode', $zipCode, PDO::PARAM_STR);
        $insertStmt->bindParam(':presentAddress', $presentAddress, PDO::PARAM_STR);
        $insertStmt->bindParam(':civilStatus', $civilStatus, PDO::PARAM_STR);
        $insertStmt->bindParam(':religion', $religion, PDO::PARAM_STR);
        $insertStmt->bindParam(':citizenship', $citizenship, PDO::PARAM_STR);
        $insertStmt->bindParam(':emailAddress', $emailAddress, PDO::PARAM_STR);
        $insertStmt->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $insertStmt->bindParam(':guardianName', $guardianName, PDO::PARAM_STR);
        $insertStmt->bindParam(':guardianMobileNumber', $guardianMobileNumber, PDO::PARAM_STR);
        $insertStmt->bindParam(':userId', $userDetails['id'], PDO::PARAM_INT);

        if ($insertStmt->execute()) {
            echo "Form submitted successfully!";
        } else {
            echo "Error submitting form. Please try again later.";
            // Log the detailed error for debugging purposes
            error_log("Form submission error: " . implode(", ", $insertStmt->errorInfo()));
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
     <br>   <a href='../acads.php'>Continue</a>
        </div>  
    </div>

</body>

</html>
