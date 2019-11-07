<!DOCTYPE html>
<!--
Name: Christina Tatang
ID: 30003663
DoB: 02/08/2000
Web Programming - Project 
-->

<head>
<title>Search Movie</title>
<!-- reference css file-->
<link rel = "stylesheet" type="text/css" href="Project.css"/>
<meta charset ="utf-8"/>

</head>
<body>
<!-- page title-->
<h1>SMT Movies Rental</h1>

<div id = "menu">
<ul>
    <!--reference for sub page -->
    <li><a href="http://localhost/Project/index.htm"><table><tr><td>Home</td></tr></table></a></li> 
    <li><a href="http://localhost/Project/myAbout.htm"><table><tr><td>About</td></tr></table></a></li> 
    <li><a href="http://localhost/Project/myContact.htm"><table><tr><td>Contact</td></tr></table></a></li> 
    <li><a href="http://localhost/Project/myHelp.htm"><table><tr><td>Help</td></tr></table></a></li> 
</ul>
</div>
    <div style="clear:both;">&nbsp;</div>
<!--php code--> 
<?php
//reference css file
echo "<link rel = 'stylesheet' type='text/css' href='Project.css'/> <meta charset ='utf-8'/>";

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
        echo "<script>setTimeout(\"location.href = 'http://localhost/Project/index.htm';\",0);</script>";
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

&nbsp;
&nbsp;
<h6><a href="https://www.w3schools.com/html/">Copyright</a></h6>
</body>
</html>
