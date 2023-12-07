<?php

@include '../functions/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing PHP code for file upload and database insertion...

    // Example: Loop through the documents array to handle file uploads
    for ($i = 0; $i < count($documents); $i++) {
        $fileInputName = "file$i";

        // Check if the file is uploaded successfully
        if ($_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            // Specify the directory to store the uploaded files
            $uploadDir = 'uploads/';
            
            // Generate a unique filename to avoid naming conflicts
            $fileName = uniqid() . '_' . $_FILES[$fileInputName]['name'];
            
            // Move the uploaded file to the designated directory
            move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $uploadDir . $fileName);

            // Save the file information to the database (replace this with your database logic)
            // Example: $sql = "INSERT INTO files (filename) VALUES ('$fileName')";
            // Execute your database query here
        }
    }
}
?>
<!--------->


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
            <p><strong><a href='home.php'>BACK</a></strong></p>
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
                <li><a href="home.php">Back to menu</a></li>
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
            <h1>New Applicant</h1>
            <h3>Upload your files here </h3>
            <form action="" method="post" enctype="multipart/form-data">

            <div class="form-container">
            

            
            <!-- Specific file upload forms with delete buttons -->
            <div class="column">
            <?php
       $documents = [
        "Endorsement letter with verification of Indigency",
        "Application letter addressed to City Mayor (Mayor Beverly Dimacuha)",
        "Report Card (Back to Back)",
        "Notarized “Sinumpaang Salaysay” or Form 2316 of parents",
        "Registration/Enrollment Form",
        "School ID (Back to Back)",
        "Birth Certificate",
        "Voters Registration Record of Parents"
    ];
    
    // Loop through the documents array and create a two-column layout
    for ($i = 0; $i < count($documents); $i += 2) {
        echo "<div class='form-item'>";
        
        // First Column
        echo "<div class='form-column'>";
        echo "<label class='form-label' for='file$i'>{$documents[$i]}:</label>";
        echo "<input class='form-input' type='file' name='file$i' id='file$i'>";
        echo "<button class='form-delete-button' type='submit' name='delete$i'>Delete</button>";
        echo "</div>";
    
        // Second Column (if available)
        if ($i + 1 < count($documents)) {
            echo "<div class='form-column'>";
            echo "<label class='form-label' for='file" . ($i + 1) . "'>{$documents[$i + 1]}:</label>";
            echo "<input class='form-input' type='file' name='file" . ($i + 1) . "' id='file" . ($i + 1) . "'>";
            echo "<button class='form-delete-button' type='submit' name='delete" . ($i + 1) . "'>Delete</button>";
            echo "</div>";
        }
    
        echo "</div>";
    }
    
    
        
?>
            
        </div>
        <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>