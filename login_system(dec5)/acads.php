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
<script>
        function checkEligibility() {
            // Get the student's average using JavaScript
            var average = parseFloat(document.getElementById("averageInput").value);

            // Check eligibility for scholarship program, financial assistance, or none
            if (average >= 85.0) {
                window.location.href = 'scholarship_program.php';
                
            } else if (average >= 82.0 && average <= 84.99) {
                window.location.href = 'financial_assistance.php';
            } else {
                window.location.href = 'not_qualified.php';
            }
        }
    </script>
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
                <li><a href="user/user.php">Back to menu</a></li>
                <li><a href="#"></a></li>
            </ul>
    </nav>
    
    <!--- header -->
    <div class="login-page">
        <div class="header">
            <h2><span>E</span><span>B</span><span>D</span> <span>S</span><span>C</span><span>H</span><span>O</span><span>L</span><span>A</span><span>R</span><span>S</span><span>H</span><span>I</span><span>P</span> <span>S</span><span>Y</span><span>S</span><span>T</span><span>E</span><span>M</span></h2>
            <h3>  SCHOLARSHIP APPLICATION  </h3>
        </div>
        
        <div class="login-container">
            <h1>GRADES</h1>
            <?php
        // Handle form submission and check eligibility using PHP
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $average = floatval($_POST["average"]);

            // Check eligibility for scholarship program, financial assistance, or none
            if ($average >= 85.0) {
                header("Location: scholarship_program.php");
                exit();
            } elseif ($average >= 82.0 && $average <= 84.99) {
                header("Location: financial_assistance.php");
                exit();
            } else {
                header("Location: not_qualified.php");
                exit();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="averageInput">Enter your average:</label>
        <input type="text" id="averageInput" name="average" required>
        <button type="button" onclick="checkEligibility()">Submit</button>
    </form>
            
        </div>
    </div>


</body>
</html>


