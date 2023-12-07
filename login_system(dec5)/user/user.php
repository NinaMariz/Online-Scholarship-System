<?php
@include 'config.php';

session_start();

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
            <li class="active"><a href="user.php">Scholar profile</a></li>
 
                    <?php
        // Modify the link based on the user_type
        $newScholarLink = ($_SESSION['user_type'] === 'athlete') ? 'athlete_scholars.php' : 'personal.php';

        // Disable the link and show a message if a record already exists
        if ($userDetails > 0) {
        } else {
            echo '<li><a href="' . $newScholarLink . '">New scholar?<br>Apply now</a></li>';
        }
        ?>

    

            <li><a href="myFiles.php">Renew application</a></li>
            <li><a href="myFiles.php">My files</a></li>
            <li><a href="notif.php">Notification</a></li><br><br><br><br><br><br><br>
           
            <a href= "../home.php" button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>


    <!----- contents---->
    <div id="content">

        <div class="user-container">




                    <h2>Personal Information</h2>
                    <?php echo $_SESSION['user_type']; ?>
                <div>
                    

                <?php
// Check if there are user details
if (!empty($userDetails)) {
    // Display user details
    ?>
    <p><strong>Fullname:</strong> <?php echo $userDetails['FirstName'] . ' ' . $userDetails['MiddleName'] . ' ' . $userDetails['LastName']; ?></p>
    <p><strong>Age:</strong> <?php echo $userDetails['Age']; ?></p>
    <p><strong>Sex:</strong> <?php echo $userDetails['Sex']; ?></p>
    <p><strong>Present Address:</strong> <?php echo $userDetails['PresentAddress']; ?></p>
    <?php
} else {
    // Display "no record" message
    echo "<p>No record found.</p>";
}
?>
    </div>
</div>


        
         
        </div>
    </div>
</body>
</html>