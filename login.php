<?php 

$password=$_POST['password'];
$key=file_get_contents('password.txt');

session_start();

if ($password == $key) {
    echo "Success";
    header("Location: main.php");
    $_SESSION['login_successful'] = true;
    exit();
  }
  else {
    echo "Wrong password";
  }

?>