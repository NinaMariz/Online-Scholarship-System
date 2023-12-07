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

// Fetch only user type from the database
$query = "SELECT * FROM user_form WHERE user_type IN ('hs','college','athlete')";
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
            <li><a href="adminprofile.php">Admin Profile</a></li>
            <li class="active"><a href="users.php">User</a></li>
            <li><a href="evaluate.php">Evaluate</a>
            <li><a href="status.php">Status</a></li><br><br><br><br><br><br><br>
           
            <a href="../home.php"><button class="appealing-button3">Sign Out</button></a>
        </ul>
    </div>
    <div id="content">
        <div class="user-container">
            <h1>User's Profile</h1>
            <form method="GET" action="">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit">Search</button><br>
                </div>
            </form>
     


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
                <tbody>
                        <?php
                        // Check if search parameter is set
                        if (isset($_GET['search'])) {
                            $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
                            $query = "SELECT * FROM user_form WHERE (user_type = 'college' OR user_type = 'hs' OR user_type = 'athlete') AND (id LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%')";
                            $result = mysqli_query($conn, $query);
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['user_type'] . "</td>";
                            echo "<td>
                                    <a href='../functions/edit.php?id={$row['id']}'><button>Edit</button></a>
                                    <a href='../functions/archive.php?id={$row['id']}'><button>Archive</button></a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
} else {
    echo "Error fetching users: " . mysqli_error($conn);
}
?>
