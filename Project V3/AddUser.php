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
	<link rel="stylesheet" type="text/css" href="Responsive.css"/>
	<style>

	</style>
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
			var x = document.getElementById( "myTopnav" );
			if ( x.className === "topnav" ) {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}
	</script>

	<!--php code-->
	<?php

	$FirstName = $_POST[ 'FirstName' ];
	$LastName = $_POST[ 'LastName' ];
	$Email = $_POST[ 'Email' ];
	$Monthly = $_POST[ 'Monthly' ];
	$Breaking = $_POST[ 'Breaking' ];

	$username = 'root';
	$password = '';

	try {
		$conn = new PDO( 'mysql:host=localhost;dbname=smtmoviesrental', $username, $password );
		//set the PDO error mode to exception 
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		//search if there is the same information
		$query = 'SELECT * FROM `membership_subscription` WHERE `FirstName` = "' . $FirstName . '" AND `LastName` = "' . $LastName . '" AND `Email` = "' . $Email . '"';
		$stmt = $conn->prepare( $query );
		$stmt->execute();
		$numRow = $stmt->rowCount();

		$stmt->bindParam( ':FirstName', $_REQUEST[ 'FirstName' ] );
		$stmt->bindParam( ':LastName', $_REQUEST[ 'LastName' ] );
		$stmt->bindParam( ':Email', $_REQUEST[ 'Email' ] );

		//if the user already exists
		if ( $numRow > 0 ) {
			echo "<h2>This user already exists.</h2>";
		}
		//if else 
		else {
			//if monthly checked box is checked
			if ( isset( $_POST[ 'Monthly' ] ) ) {
				$Monthly = 1;
			} else {
				$Monthly = 0;
			}

			//if breaking checked box is checked
			if ( isset( $_POST[ 'Breaking' ] ) ) {
				$Breaking = 1;
			} else {
				$Breaking = 0;
			}

			$sql = 'INSERT INTO `membership_subscription`( `FirstName`, `LastName`, `Email`, `Monthly`, `Breaking`) VALUES (:FirstName,:LastName,:Email,:Monthly,:Breaking)';
			$stmt = $conn->prepare( $sql );

			$stmt->bindParam( ':FirstName', $_REQUEST[ 'FirstName' ] );
			$stmt->bindParam( ':LastName', $_REQUEST[ 'LastName' ] );
			$stmt->bindParam( ':Email', $_REQUEST[ 'Email' ] );
			$stmt->bindParam( ':Monthly', $Monthly );
			$stmt->bindParam( ':Breaking', $Breaking );

			$stmt->execute();
			echo '<h2> The user has been added. </h2>';
/*
			$header = "From: christina2820@gmail.com";
			$result =  mail($Email, "Movies Rental Subscription", "Thank you for your subscription");
			var_dump($result);
			*/
		}
	} catch ( PDOException $e ) {
		echo 'ERROR: ' . $e->getMessage();
	}
	$conn = null;
	echo "</table>";
	?>
	<br>
	<br>
	<h6 style='margin-left:1.5em'>Copyright to Acme Entertainment Pty Ltd</h6>
</body>
</html>



