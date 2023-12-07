<?php
@include 'functions/config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:part.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['file'])) {
    $fileId = $_GET['id'];
    $fileField = $_GET['file'];

    // Fetch file details based on the file ID
    $fileDetailsQuery = "SELECT * FROM user_files WHERE id = '$fileId'";
    $fileDetailsResult = mysqli_query($conn, $fileDetailsQuery);

    if ($fileDetailsResult) {
        $fileDetails = mysqli_fetch_assoc($fileDetailsResult);
        $fileName = $fileDetails[$fileField];
    } else {
        // Handle the case where the query for file details fails
        $fileName = '';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileId = $_POST['file_id'];
    $fileField = $_POST['file_field'];

    // Process file upload for the specified file field
    $newFileName = $_FILES['new_file']['name'];
    $uploadFolder = 'uploads/';
    move_uploaded_file($_FILES['new_file']['tmp_name'], $uploadFolder . $newFileName);

    // Update the file name in the database
    $updateQuery = "UPDATE user_files SET $fileField = '$newFileName' WHERE id = '$fileId'";
    mysqli_query($conn, $updateQuery);

    // Redirect to the view page or do further processing
    header('location: user/user.php');
    exit();
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
    <title>Edit File</title>
</head>
<body>
    <nav>
        <!-- Your navigation code here -->
    </nav>

    <div class="edit-file-page">
        <h2>Edit File</h2>

        <?php
        if (isset($fileName)) {
            echo "<p>Editing File: $fileName</p>";
        }
        ?>

        <form action="edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="file_id" value="<?php echo $fileId; ?>">
            <input type="hidden" name="file_field" value="<?php echo $fileField; ?>">

            <label for="new_file">Upload New Version:</label>
            <input type="file" name="new_file" required><br>

            <input type="submit" value="Upload and Save">
        </form>
    </div>
</body>
</html>
