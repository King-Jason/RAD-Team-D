<!DOCTYPE html>
<!--
Version 1 : Original Document : Christina Tatang
Version 2.1: Made website responsive : Jason King
Version 3 : Made membership page and administrative functions : Christina Tatang
//-->

<!--show all the user -->
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

<!--php code--> 
<?php

echo "<br><table style='margin-left: 1.5em; border: solid 1px black;'>";
echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
class TableRows extends RecursiveIteratorIterator
{
    function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }
    function current()
    {
        return "<td style=' width:150px; border:1px solid black;'>" . parent::current(). "</td>";
    }
    function beginChildren()
    {
        echo "<tr>";
    }
    function endChildren()
    {
        echo "</tr>" . "\n";
    }
} 


$username = 'root';
$password = '';
try 
{
    $conn = new PDO('mysql:host=localhost;dbname=smtmoviesrental', $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT `MemberID`, `FirstName`, `LastName`, `Email` FROM `membership_subscription`');
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	//outputting all the table
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v)
	{
        echo $v;
    }
}
catch(PDOException $e) 
{
    echo 'ERROR: ' . $e->getMessage();
}
$conn = null;
echo "</table>";
?>

	<br>
	<br>
<h6 style= 'margin-left:1.5em'>Copyright to Acme Entertainment Pty Ltd</h6>
</body>
</html>

