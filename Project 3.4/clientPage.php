<?php
session_start();
isset($_SESSION['user_id']);
isset($_SESSION['user_fName']);
isset($_SESSION['user_pLevel']);
?>
<!DOCTYPE html>
<!--
Version 1 : Original Document : Christina Tatang
Version 2.1: Made website responsive : Jason King
Version 3 : Made membership page and administrative functions : Christina Tatang
//-->
<html>
<head>
<!--Reference for CSS Style & Responsive design-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel = "stylesheet" type="text/css" href="Responsive.css"/>
    
</head>
<body>
    <header>
        <h1>Welcome to my Movies Rental page</h1>
    </header>
	
<!--Navigation Bar-->
<div class="topnav" id="myTopnav">
  <a href="index.html" class="active">Home</a>
  <a href="myAbout.html">About</a>
  <a href="myContact.html">Contact</a>
  <a href="myHelp.html">Help</a>
  <a href="membership.html">Subscribe</a>
  <a href="clientPage.php">Client</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<!--function for responsive design-->
<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
<?php
if (isset( $_SESSION['user_id'] ) ) {
    echo '
    <form class="client-form" action="clientLogout.inc.php" method="post">
    <button type="submit">Logout</button>
    </form>
    <form class="client-form" action="clientRating.inc.php" method="post">
    <div>
    <label>Movie ID</label>
        <input type="text" name="MID" required>
    </div>
    <div>
    <label>Star Rating</label>
        <input type="number" name="SRating" min="1" max="5" required>
    </div>
    <button type="submit">Rate!</button>
    </form>
    <form class="client-form" action="RatingSearch.php" method="post">
    Click here to see the rating search <br/>
    <input type="submit" value="Rating Search" >
  </form>
';
}else {
    echo '
    <form class="client-form"action="clientSignup.inc.php" method="post">
    <div>
        <label>Name</label>
        <input type="text" name="Name" required>
    </div>
    <div>
        <label>Email</label>
        <input type="text" name="Email" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="Password" required>
    </div>
    <button type="submit">Signup</button>
</form>

<form class="client-form" action="login.inc.php" method="post">
    <div>
        <label>Email</label>
        <input type="text" name="Email" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="Password" required>
    </div>
    <button type="submit">Login</button>
</form>
    ';
}
?>

</body>
</html>

