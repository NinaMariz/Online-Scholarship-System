<?php
@include '../functions/config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:part.php');
   exit();
}

// Fetch details of the logged-in user
$adminName = $_SESSION['admin_name'];
$userDetailsQuery = "SELECT * FROM user_form WHERE name = '$adminName'";
$userDetailsResult = mysqli_query($conn, $userDetailsQuery);

// Check if the query was successful
if ($userDetailsResult) {
    $userDetails = mysqli_fetch_assoc($userDetailsResult);

    // Fetch records from user_form based on the user's ID
    $userId = $userDetails['id'];
} 

?> 
<?php echo $userDetails['id']; ?>
<?php
@include '../functions/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Start a transaction
    mysqli_autocommit($conn, false);
    $success = true;

    // Update the user details in the user_form table
    $updateUserQuery = "UPDATE user_form SET name = '$name', email = '$email', password = '$password', user_type = '$user_type' WHERE id = $id";

    if (!mysqli_query($conn, $updateUserQuery)) {
        $success = false;
        echo "Error updating user details: " . mysqli_error($conn);
    }

    // Delete records from another_table based on the user's ID
    $deleteQuery = "DELETE FROM student_records WHERE ExistingTableID = $id";

    if (!mysqli_query($conn, $deleteQuery)) {
        $success = false;
        echo "Error deleting records from another_table: " . mysqli_error($conn);
    }

    // Commit or rollback the transaction based on success
    if ($success) {
        mysqli_commit($conn);
        echo "User details updated successfully!";
    } else {
        mysqli_rollback($conn);
    }

    // End the transaction
    mysqli_autocommit($conn, true);
}
?>

<a href="../admin/admin.php" button class="appealing-button3">Back</button></a>
