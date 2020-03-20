<?php
session_start();
if (isset($_SESSION['login_successful']) || $_SESSION['login_successful']) {
}
else{
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
<title>6A - Things To Do</title>
<meta charset="utf-8">
<link rel="icon" href="icon.svg">
<link rel="apple-touch-icon" href="touch-icon.png">


<link rel="stylesheet" href="stylesheets/common.css">
<link rel="stylesheet" href="stylesheets/table.css">
<link rel="stylesheet" href="stylesheets/subjects.css">
  
</head>

<body>
  <div class="topbar">
    <topitem class="header"><img src="images/school.svg" style="height: 24px; vertical-align: baseline;"> 6A </topitem>
    <topitem class="label"><span>Things To Do</span></topitem>
    
    <topitem class="user-dropdown">
      
      <form method="post" action="set_user.php">
        <span><img src="images/user-circle.svg" style="height: 24px; vertical-align: middle;">
        <select name="user">
          <option value="all"> Students </option>
          
          <?php 
            include 'userlist_build.php';
            
            echo build_userdropdown();
           ?>
           
        </select></span>
        <input type="submit" value="✓">
      </form>
    </topitem>
  </div>
  <br>
  
<?php 
include 'table_build.php';
  
$work = file('data/work/work.txt');
      
if (isset($_COOKIE['user']) == false) {
  $user = "all";
}
else {
  $user = $_COOKIE['user'];
}

table_build($work, $user);
?>
   
</body>
</html>