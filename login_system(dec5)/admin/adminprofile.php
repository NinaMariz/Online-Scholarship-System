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

    // Fetch records from student_records based on the user's ID
    $userId = $userDetails['id'];
} 
?> 


<?php
// Assume you have a connection in config.php
@include '../functions/config.php';

// Fetch only admin users from the database
$query = "SELECT * FROM user_form WHERE user_type = 'admin'";
$result = mysqli_query($conn, $query);

if ($result) {
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>

        button {
            padding: 8px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        a button {
            text-decoration: none;
            color: white;
        }

        a button:hover {
            background-color: #45a049;
        }

        .add-admin-button{
            position: absolute;
            bottom: 30px; /* Adjust the bottom position as needed */
            right: 130px;
            padding: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .done-button {
            position: absolute;
            bottom: 30px; /* Adjust the bottom position as needed */
            right: 50px;
            padding: 13px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .add-admin-button:hover,
        .done-button:hover {
            background-color: #45a049;
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
                <div class="bat"><strong><i>Eto Batangueno Disiplinado!</i></strong></div>
            </ul>
        </header>
        <div class="dashboard">
            Admin dashboard
            
        </div>
        <ul class="nav-list">
            <li class="active"><a href="adminprofile.php">Admin Profile</a></li>
            <li><a href="users.php">User</a></li>
            <li><a href="evaluate.php">Evaluate</a></li>
            <li><a href="status.php">Status</a><br><br><br><br><br><br><br>
           
            <a href="../home.php"><button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>
    <div id="content">
        <div class="user-container">
        
            <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
</div>
               <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['user_type'] . "</td>";
                                echo "<td>
                                        <a href='../functions/edit.php?id={$row['id']}'><button>Edit</button></a>
                                        <a href='../functions/delete.php?id={$row['id']}'><button>Delete</button></a>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
            </table>
        </div>
        <a href="add.php" class="add-admin-button">
                <button>Add Admin</button>
            </a>
            <!-- Move "Done" button to the right -->
            <button class="done-button">Done</button>
    </div>
</body>
</html>
<?php
} else {
    echo "Error fetching admin users: " . mysqli_error($conn);
}
?>