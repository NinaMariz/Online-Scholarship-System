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

}

?>
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/acads.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@1&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gabarito&family=Noto+Sans+Georgian:wght@700&display=swap" rel="stylesheet">
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
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul>
        </div>
    </nav>
    
    <!--- header -->
    <div class="login-page">
        <div class="header">
            <h2><span>E</span><span>B</span><span>D</span> <span>S</span><span>C</span><span>H</span><span>O</span><span>L</span><span>A</span><span>R</span><span>S</span><span>H</span><span>I</span><span>P</span> <span>S</span><span>Y</span><span>S</span><span>T</span><span>E</span><span>M</span></h2>
            <h3>  SCHOLARSHIP APPLICATION  </h3>
        </div>
        
        <div class="login-container">
            <h1>Assessment</h1>
            <h3>Our assessment shows that you are qualified to apply
for our <p>Scholarship Program</p>Please proceed for the registration and uploading of documents for the processing and authentication</h3>

           
     <a href="autoscholars.php"><button id="continueButton">Continue</button></a>
   
        </div>
    


</body>
</html>


