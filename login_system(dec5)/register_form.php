<?php
@include 'functions/config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Server-side password strength validation
   if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/', $_POST['password'])) {
      $error[] = 'Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one digit, and one special character.';
   }

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $error[] = 'User already exists!';
   } else {
      if ($pass != $cpass) {
         $error[] = 'Passwords do not match!';
      } else {
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location: part.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

   <script>
   function validatePassword() {
      var password = document.getElementById("password").value;
      var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/;

      if (!passwordRegex.test(password)) {
         document.getElementById("password").setCustomValidity("Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one digit, and one special character.");
      } else {
         document.getElementById("password").setCustomValidity('');
      }

      return true;
   }
</script>
</head>
<body>
   <nav class="nav">
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

   <div class="form-container">
      <form action="" method="post" onsubmit="return validatePassword()">
         <h3>Register Now</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="text" name="name" required placeholder="Enter your name">
         <input type="email" name="email" required placeholder="Enter your email">
         <input type="password" name="password" id="password" required placeholder="Enter your password" oninput="validatePassword()">
         <input type="password" name="cpassword" required placeholder="Confirm your password">
         <select name="user_type">
            <option value="hs">High School</option>
            <option value="college">College</option>
            <option value="athlete">Athlete</option>
         </select>
         <input type="submit" name="submit" value="Register Now" class="form-btn">
         <p>Already have an account? <a href="part.php">Login Now</a></p>
      </form>
   </div>
</body>
</html>
