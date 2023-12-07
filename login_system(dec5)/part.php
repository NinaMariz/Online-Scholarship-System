
<?php

@include 'functions/config.php';

session_start();

if(isset($_POST['submit'])){

    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $pass = isset($_POST['password']) ? md5($_POST['password']) : '';
    $cpass = isset($_POST['cpassword']) ? md5($_POST['cpassword']) : '';
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);
      $_SESSION['user_type'] = $row['user_type'];
      var_dump($_SESSION);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin/admin.php');


      } elseif($row['user_type'] == 'sub_admin'){

        $_SESSION['user_name'] = $row['name'];
        header('location:user/user.php');

     }
      elseif($row['user_type'] == 'hs'){

         $_SESSION['user_name'] = $row['name'];
         header('location:user/user.php');

      }elseif($row['user_type'] == 'college'){

        $_SESSION['user_name'] = $row['name'];
        header('location:user/user.php');

     }elseif($row['user_type'] == 'athlete'){

        $_SESSION['user_name'] = $row['name'];
        header('location:user/user.php');

     }
     
   }

};
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

<script>
        window.onload = function () {
            // Check if the URL contains a query parameter indicating a login error
            const urlParams = new URLSearchParams(window.location.search);
            const loginError = urlParams.get('loginError');

            if (loginError) {
                // Display an alert if the loginError parameter is present
                alert('Wrong email or password');
            }
        };
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
                <li><a href="home.php">Back to menu</a></li>
                <li><a href="#"></a></li>
            </ul>
        </div>
    </nav>
    
    <!--- header -->
    <div class="login-page">
        <div class="header">
            <h2><span>E</span><span>B</span><span>D</span> <span>S</span><span>C</span><span>H</span><span>O</span><span>L</span><span>A</span><span>R</span><span>S</span><span>H</span><span>I</span><span>P</span> <span>S</span><span>Y</span><span>S</span><span>T</span><span>E</span><span>M</span></h2>
        </div>
        
        <div class="login-container">
            <h2>LOGIN</h2>
            <form action="?loginError=true" method="post">
               

                <label for="username">Username</label>
                <input type="email" name="email" required placeholder="enter your E-mail">
                <label for="password">Password</label>
                <input type="password" name="password" required placeholder="enter your password">
                <button type="submit" name="submit" value="login now" class="button">Login</button>
            </form>
            <a href="#" class="forget" >Forget password?</a>
            <a href="register_form.php" class="signup">Want to be a scholar? Click here!</a>
            
        </div>
    </div>

    
</body>
</html>


