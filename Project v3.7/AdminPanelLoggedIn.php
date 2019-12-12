<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 Version 1.2: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier refer
    to optimisation report for demo : Kyle Cleofe
 
 Copyright to Acme Entertainment Pty Ltd
-->
<html>
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Movie Database<br>Admin Panel</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Dashboard</a> 
    <a onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Users</a>
    <form action="logout.inc.php"> 
        <button type="submit" class="w3-bar-item w3-button w3-hover-white">Logout</button>
    </form>
    
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Movie Database Admin Panel</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Welcome <?php echo $_SESSION['user_fName'];?></b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Stats</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>
  
  <!-- Stats-->
  <div class="w3-row-padding">
    <div class="w3-half">
    <div class="w3-row-padding">
    <div class="w3-half w3-margin-bottom">
      <ul class="w3-ul w3-light-grey w3-center">
        <li class="w3-dark-grey w3-xlarge w3-padding-32">Total Users</li>
        <li class="w3-padding-16"><?php
        $conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

        if (!$conn) {
            die("Connection to servers failed. Error: " . mysqli_connect_error());
        }

        if ($result = mysqli_query($conn, "SELECT * FROM users")) {

            /* determine number of rows result set */
            $row_cnt = mysqli_num_rows($result);
        
            printf($row_cnt);
        
            /* close result set */
            mysqli_free_result($result);
        }
        ?></li>
      </ul>
    </div>
    </div>
  </div>

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>

  <!-- Users -->
  <div class="w3-container" id="services" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Users</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    
          <!-- Create Admin Account-->
    <div class="w3-container" id="Login" style="margin-top:75px">
        <h2 class="w3-xxxlarge w3-text-red"><b>Create new Admins</b></h2>
        <form action="createAdmin.inc.php" method="post">
        <div class="w3-section">
            <label>Name</label>
            <input class="w3-input w3-border" type="text" name="Name" required>
        </div>
        <div class="w3-section">
            <label>Email</label>
            <input class="w3-input w3-border" type="text" name="Email" required>
        </div>
        <div class="w3-section">
            <label>Admin Level</label>
            <input class="w3-input w3-border" type="text" name="pLevel" required>
        </div>
        <div class="w3-section">
            <label>Password</label>
            <input class="w3-input w3-border" type="Password" name="Password" required>
        </div>
        <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom">Create</button>
        </form> 
        <?php
        if(isset($_GET['error'])) {
            if($_GET['error'] == "passwordstrength") {
                echo "<p class=signuperror>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>";
            }
            else if($_GET['error'] == "usertaken") {
                echo "<p class=signuperror>User with this email address is already in use</p>";
            }
            else if($_GET['error'] == "wrongemail") {
                echo "<p class=signuperror>Enter a correct email!</p>";
            }
        }
        if(isset($_GET['create'])) {
            if($_GET['create'] == "created") {
                echo "<p class=created>Succesfully Added User!</p>";
            }
        }
        ?> 
    </div>
  </div>



<!-- End page content -->
</div>

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>
</html>