<?php
@include '../functions/config.php';

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

    // Fetch records from user_files based on the user's ID
    $userId = $userDetails['id'];
    $userFilesQuery = "SELECT * FROM user_files WHERE user_id = '$userId'";
    $userFilesResult = mysqli_query($conn, $userFilesQuery);
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
    $userFilesResult = false; // Set result to false
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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

            if (!isset($_SESSION['user_name'])) {
                header('location:part.php');
                exit();
            }

            $userName = $_SESSION['user_name'];
            $userDetailsQuery = "SELECT * FROM personal_table WHERE user_id = (SELECT id FROM user_form WHERE name = :userName)";
            $userDetailsStmt = $pdo->prepare($userDetailsQuery);
            $userDetailsStmt->bindParam(':userName', $userName, PDO::PARAM_STR);
            $userDetailsStmt->execute();
            $userDetails = $userDetailsStmt->fetch(PDO::FETCH_ASSOC);

            if ($userDetails) {
                // Display the user's form data

                $userDetails['FirstName'] . "</p>";
                $userDetails['LastName'] . "</p>";
                $userDetails['MiddleName'] . "</p>";
                $userDetails['Age'] . "</p>";
                $userDetails['Sex'] . "</p>";
                $userDetails['PresentAddress'] . "</p>";
            } else {
                echo "";
            }
            ?>
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
        if ($userDetails > 0) {
        } else {
            echo '<li><a href="' . $newScholarLink . '">New scholar?<br>Apply now</a></li>';
        }
        ?>

            <li><a href="evaluate.php">Renew application</a></li>
            <li class="active"><a href="myFiles.php">My files</a></li>
            <li><a href="notif.php">Notification</a></li><br><br><br><br><br><br><br>
           
            <a href= "../home.php" button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>


    <!----- contents---->
    <div id="content">

        <div class="user-container">


            <?php
    @include 'config.php';


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
<form>
<h2>View Uploaded Files</h2>

<?php
if ($userFilesResult) {
    while ($fileRow = mysqli_fetch_assoc($userFilesResult)) {
        echo "<div class='file-info'>";
        echo "<p>File 1: <a href='../uploads/{$fileRow['file1']}' download>{$fileRow['file1']}</a> | <a href='../edit.php?id={$fileRow['id']}&file=file1'>Edit</a></p>";
        echo "<p>File 2: <a href='../uploads/{$fileRow['file2']}' download>{$fileRow['file2']}</a> | <a href='../edit.php?id={$fileRow['id']}&file=file2'>Edit</a></p>";
        echo "<p>File 3: <a href='../uploads/{$fileRow['file3']}' download>{$fileRow['file3']}</a> | <a href='../edit.php?id={$fileRow['id']}&file=file3'>Edit</a></p>";
        echo "<p>File 4: <a href='../uploads/{$fileRow['file4']}' download>{$fileRow['file4']}</a> | <a href='../edit.php?id={$fileRow['id']}&file=file4'>Edit</a></p>";
        echo "<p>File 5: <a href='../uploads/{$fileRow['file5']}' download>{$fileRow['file5']}</a> | <a href='../edit.php?id={$fileRow['id']}&file=file5'>Edit</a></p>";
        echo "<p>File 6: <a href='../uploads/{$fileRow['file6']}' download>{$fileRow['file6']}</a> | <a href='../edit.php?id={$fileRow['id']}&file=file6'>Edit</a></p>";
        echo "</div>";
    }
} else {
    echo "<p>No files uploaded yet.</p>";
}
?>
            </form>

        
         
        </div>
    </div>
</body>
</html>