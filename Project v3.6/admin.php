<!--
 Version 1: Original Document : Christina Tatang
 Version 2.1: Made website responsive : Jason King
 Version 3: Made membership page and administrative functions : Christina Tatang
 Version 3.1: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier refer
    to optimisation report for demo : Kyle Cleofe
 
 Copyright to Acme Entertainment Pty Ltd
-->
<?php
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
  $username = 'root';
    $password = '';
try 
{
    $conn = new PDO('mysql:host=localhost;dbname=smtmoviesrental', $username, $password);
    // set the PDO error mode to exception 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //search of the related information in the database
    $query='SELECT * FROM `admin` WHERE `Username` = "'.$Username.'" AND `Password` = "'.$Password.'"';
    $stmt = $conn->prepare($query);
    
    $stmt->execute();
    $numRow = $stmt ->rowCount();
    if ($numRow > 0 ) {
        header("location:admin.html");
    } else {
        echo "failed";
    }
}
catch(PDOException $e) 
{
    echo 'ERROR: ' . $e->getMessage();
}
?>
