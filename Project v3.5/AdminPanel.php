<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 Version 1.2: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier refer
    to optimisation report for demo : Kyle Cleofe
 
 Copyright to Acme Entertainment Pty Ltd
-->
<!DOCTYPE html>
<html lang="en">
<title>Admin Panel</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel = "stylesheet" type="text/css" href="adminpanel.css"/>
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
</style>
<body>
<?php
session_start();
if (isset($_SESSION['user_id']) ) {
    // Grab user data from the database using the user_id
    // Let them access the "logged in only" pages
    include 'AdminPanelLoggedIn.php';
    isset($_SESSION['user_fName']);
    isset($_SESSION['user_pLevel']);
} else {
    // Redirect them to the login page
    echo '
      <!-- Log In -->
  <div class="w3-container" id="Login" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Login</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <form action="adminLogin.inc.php" method="post">
      <div class="w3-section">
        <label>Email</label>
        <input class="w3-input w3-border" type="text" name="Email" required>
      </div>
      <div class="w3-section">
        <label>Password</label>
        <input class="w3-input w3-border" type="Password" name="Password" required>
      </div>
      <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom">Login</button>
    </form>  
  </div>
  <div class="w3-container" id="Login" style="margin-top:75px">
  <h1 class="w3-xxxlarge w3-text-red"><b>Reset Password</b></h1>
  <hr style="width:50px;border:5px solid red" class="w3-round">
  <form action="resetPassword.inc.php" method="post">
    <div class="w3-section">
      <label>Email</label>
      <input class="w3-input w3-border" type="text" name="Email" required>
    </div>
    <div class="w3-section">
      <label>Current Password</label>
      <input class="w3-input w3-border" type="Password" name="CPassword" required>
    </div>
    <div class="w3-section">
    <label>New Password</label>
    <input class="w3-input w3-border" type="Password" name="NPassword" required>
  </div>
    <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom">Reset</button>
  </form>  
</div>
    ';
}
?>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] == "passwordstrength") {
        echo "<p class=signuperror>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>";
    } else if ($_GET['error'] == "usertaken") {
        echo "<p class=signuperror>User with this email address is already in use</p>";
    } else if ($_GET['error'] == "wrongemail") {
        echo "<p class=signuperror>Enter a correct email!</p>";
    }
}
if(isset($_GET['create'])) {
    if ($_GET['create'] == "created") {
        echo "<p class=created>Succesfully Added User!</p>";
    }
}
?> 
</body>
</html>
