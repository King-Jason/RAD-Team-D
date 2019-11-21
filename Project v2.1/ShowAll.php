<!--
Version 1 : Original Document : Christina Tatang
//-->
<!DOCTYPE html>
<!--
Name: Christina Tatang
ID: 30003663
DoB: 02/08/2000
Web Programming - Project 
-->

<head>
<title>Show All Movies</title>
<!-- reference css file-->
<link rel = "stylesheet" type="text/css" href="Project.css"/>
<meta charset ="utf-8"/>

</head>

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
<body>
<!--php code--> 
<?php
//reference css file
echo "<link rel = 'stylesheet' type='text/css' href='Project.css'/> <meta charset ='utf-8'/>";

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>ID</th><th>Title</th><th>Studio</th><th>Status</th><th>Sound</th><th>Versions</th><th>RecRetPrice</th><th>Rating</th><th>Year</th><th>Genre</th><th>Aspect</th></tr>";
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
$username = 'root';
$password = '';
try 
{
    $conn = new PDO('mysql:host=localhost;dbname=smtmoviesrental', $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM `moviesrental_table`');
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	//outputting all the table
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
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

&nbsp;
&nbsp;
<h6><a href="https://www.w3schools.com/html/">Copyright</a></h6>
</body>
</html>
