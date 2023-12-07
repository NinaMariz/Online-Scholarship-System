<?php
@include 'functions/config.php';

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
} else {
    // Handle the case where the query for user details fails
    $userDetails = array(); // Set empty details
    $studentRecordsResult = false; // Set result to false
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@1&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito&family=Noto+Sans+Georgian:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="left">
            
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
                <li><a href="user/user.php">Back to menu</a></li>
                <li><a href="#"></a></li>
            </ul>
        </div>
    </nav>
    
    <!--- header -->
    <div class="upload-page">
        <div class="header">
            <h2><span>E</span><span>B</span><span>D</span> <span>S</span><span>C</span><span>H</span><span>O</span><span>L</span><span>A</span><span>R</span><span>S</span><span>H</span><span>I</span><span>P</span> <span>S</span><span>Y</span><span>S</span><span>T</span><span>E</span><span>M</span></h2>
            <h3>SCHOLARSHIP APPLICATION</h3>
        </div>
        
        <div class="upload-container">
            <h1>Automatic Scholars</h1>
            <h3>Upload your files here </h3>
            <form action="upload.php" method="post" enctype="multipart/form-data">

            <div class="form-container">
            <?php echo $userDetails['id']; ?>

            
            <!-- Specific file upload forms with delete buttons -->
            <div class="column">
            <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file1">File 1:</label>
        <input type="file" name="file1" required><br>

        <label for="file2">File 2:</label>
        <input type="file" name="file2" required><br>

        <label for="file3">File 3:</label>
        <input type="file" name="file3" required><br>

        <label for="file4">File 4:</label>
        <input type="file" name="file4" required><br>

        <label for="file5">File 5:</label>
        <input type="file" name="file5" required><br>

        <label for="file6">File 6:</label>
        <input type="file" name="file6" required><br>

        <!-- Repeat the above block for files 2 to 6 -->

        <input type="submit" value="Upload">
    </form>
            
        </div>
        <input type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
      

       

               
            

    

    
</body>
</html>


