<?php

  require("./config/db.php");

  if (isset($_POST['register'])) {

    // $fullname = $_POST['fullname'];
    // $email = $_POST['email'];
    // $password = $_POST['password'];

    $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    //1 - CHECK IF EMAIL IS TAKEN

    if( filter_var ($email, FILTER_SANITIZE_EMAIL)) {
      $stmt = $pdo-> prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $totalUsers = $stmt->rowCount();

      // echo $totalUsers. '<br />';



      if ($totalUsers > 0) {
        $emailTaken = "Email Already Taken";
      } else {
        //INSERTS TO DATABASE IF EMAIL IS NOT TAKEN
        $stmt = $pdo-> prepare("INSERT INTO users (fullname, email, password) VALUES (?,?,?)");
        $stmt->execute([$fullname, $email, $passwordHashed]);
      }
    }



  }

 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Worship Contact</title>
  </head>
  <body>




    <h1>Register Here</h1>
    <a href="index.php">home</a>


    <form action="register.php" method="post">


      <?php if(isset($emailTaken)) {?>

        <p style="color:red"><?php echo $emailTaken ?></p>

      <?php } ?>

        </php>

      <label for="fullname">Full Name</label>
      <input required name="fullname" type="text" placeholder="Please enter your full name" /><br />

      <label for="email">Email Address</label>
      <input required name="email" type="email" placeholder="Please enter your full name" /><br />



      <label for="password">Password</label>
      <input required name="password" type="password" placeholder="Please enter your full name" /><br />

      <button name="register" type="submit" />Save</button>


    </form>

  </body>
</html>
