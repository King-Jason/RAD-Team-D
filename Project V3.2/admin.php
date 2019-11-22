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
    if($numRow > 0 ){
        header("location:admin.html");
    }
    else{
      echo "failed";
    }
  }
    catch(PDOException $e) 
{
    echo 'ERROR: ' . $e->getMessage();
}
?>
