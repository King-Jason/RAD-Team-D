<!--
 Version 1 : Original Document : Christina Tatang
 Version 2.1: Made website responsive : Jason King
 Version 3 : Made membership page and administrative functions : Christina Tatang
 Version 3.1: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier refer
    to optimisation report for demo :Kyle Cleofe 
 
 Copyright to Acme Entertainment Pty Ltd
-->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel = "stylesheet" type="text/css" href="Responsive.css"/>
<style>

</style>
</head>
<body>
    <header>
        <h1>Welcome to my Movies Rental page</h1>
    </header>
<!--Jason King P465642 14/11/2019-->
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

<!----------------------------->
<?php
//reference css file

$Search = $_POST['Search'];
$Genre = $_POST['Genre'];
$Rating = $_POST['Rating'];
$Year = $_POST['Year'];
$username = 'root';
$password = '';


try 
{
    //if the text box is empty
    if(!empty($Search)) {
        $query = 'SELECT * FROM `moviesrental_table` WHERE `Title` LIKE "%'.$Search.'%"
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Rating` LIKE "%'.$Rating.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Year` LIKE "%'.$Year.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" AND `Rating` LIKE "%'.$Rating.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" AND`Year` LIKE "%'.$Year.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Year` LIKE "%'.$Year.'%" AND `Rating` LIKE "%'.$Rating.'%"';
    }
    else if(!empty($Genre)) {
        $query = 'SELECT * FROM `moviesrental_table` WHERE `Genre` LIKE "%'.$Genre.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" AND `Rating` LIKE "%'.$Rating.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" AND`Year` LIKE "%'.$Year.'%" 
	OR `Genre` LIKE "%'.$Genre.'%" AND `Rating` LIKE "%'.$Rating.'%" AND `Year`LIKE "%'.$Year.'%" ';
    }
    else if(!empty($Rating)) {
        $query = 'SELECT * FROM `moviesrental_table` WHERE `Rating` LIKE "%'.$Rating.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Rating` LIKE "%'.$Rating.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" AND `Rating` LIKE "%'.$Rating.'%" 
	OR `Genre` LIKE "%'.$Genre.'%" AND `Rating` LIKE "%'.$Rating.'%" AND `Year`LIKE "%'.$Year.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Year` LIKE "%'.$Year.'%" AND `Rating` LIKE "%'.$Rating.'%"';
    }
    else if(!empty($Year)) {
        $query = 'SELECT * FROM `moviesrental_table` WHERE `Year` LIKE "%'.$Year.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Year` LIKE "%'.$Year.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Genre` LIKE "%'.$Genre.'%" AND`Year` LIKE "%'.$Year.'%" 
	OR `Genre` LIKE "%'.$Genre.'%" AND `Rating` LIKE "%'.$Rating.'%" AND `Year`LIKE "%'.$Year.'%" 
	OR `Title` LIKE "%'.$Search.'%" AND `Year` LIKE "%'.$Year.'%" AND `Rating` LIKE "%'.$Rating.'%"';
    }
    //else outputting a pop up message and redirect to index page
    else if(empty($Search) && empty($Year) && empty($Rating) && empty($Genre)) {
        $query = 'SELECT * FROM `moviesrental_table` WHERE 0';
        $message = "The text box is empty.\\nPlease check your input again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo "<script>setTimeout(\"location.href = 'http://localhost/Project/index.html';\",0);</script>";
    }

    $conn = new PDO('mysql:host=localhost;dbname=smtmoviesrental', $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':Search', $_REQUEST['Search']);
    $stmt->bindParam(':Genre', $_REQUEST['Genre']);
    $stmt->bindParam(':Rating', $_REQUEST['Rating']);
    $stmt->bindParam(':Year', $_REQUEST['Year']);
                
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $numRow = $stmt ->rowCount();
    
    //if found
    if($numRow > 0) {
        
        //create table and outputting the result
        echo "<table style='border: solid 1px black; border-collapse:collapse;'>";
        echo "<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Studio</th>
		<th>Status</th>
		<th>Sound</th>
		<th>Versions</th>
		<th>RecRetPrice</th>
		<th>Rating</th>
		<th>Year</th>
		<th>Genre</th>
        <th>Aspect</th>
        <th>Likes</th>
        <th>Dislikes</th>
		</tr>";
        class TableRows extends RecursiveIteratorIterator
        {
            function __construct($it)
            {
                parent::__construct($it, self::LEAVES_ONLY);
            }
            function current()
            {
                return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
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
        

        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) 
        {
            echo $v;
        }
            
        //insert the searched movie to different table
        if(!empty($Search)) {
            $latest = 'INSERT INTO `movies_latest`(`Latest`) VALUES ("'.$Search.'")';
            $stmt = $conn->prepare($latest);                
            $stmt->execute();
        }
    
        
    
    }
    //if not found outputting user friendly
    else{
        echo "<h2 style='margin-left: 10px;'> Thank you for using our website search engine.<br> We couldn't find the information that you searching about, please search for another information. :) </h2>";  
    }
    
}
catch(PDOException $e) 
{
    echo 'ERROR: ' . $e->getMessage();
}
$conn = null;
    echo "</table><br>";
?>
    <br>
    <br>
    <h6 style='margin-left:1.5em'>Copyright to Acme Entertainment Pty Ltd</h6>
</body>
</html>
