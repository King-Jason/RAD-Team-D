<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 Version 1.2: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier refer
    to optimisation report for demo : Kyle Cleofe
 Version 3: made client login and rating : Jason King
 Version 3.1 Made likes and dislikes for client and ui experience easier :Kyle Cleofe
 
 Copyright to Acme Entertainment Pty Ltd
-->
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
		  <a title = "Goes to home page" href="index.html" class="active">Home</a>
		  <a title = "Goes to about page" href="myAbout.html">About</a>
		  <a title = "Goes to contact page" href="myContact.html">Contact</a>
		  <a title = "Goes to help page" href="myHelp.html">Help</a>
		  <a title = "Goes to membership page" href = "membership.html">Subscribe</a>
		  <a title = "Goes to client page" href="clientPage.php">Client</a>
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
	$conn = mysqli_connect("localhost", "root", "", "smtmoviesrental");
	
	if (isset($_SESSION['user_id']) ) {
		
		//form properties for search
		echo '
		<form class="client-form" action="clientLogout.inc.php" method="post">
			<button title = "Click to logout" type="submit">Logout</button>
		</form>
		
		<form class="client-form" action = "clientPage.php" method = "post">
			<h2>Search Movies by any column</h2>
			<input type="text" name="TBSearch" style="font-size:12pt;" placeholder="Search"><br><br>
			<input type="submit" name = "BtnSearch" id="BtnSearch" value = "Search"><br><br>
			
			<h2>Advanced search</h2>
			<input type="text" name="TBSearchGenre" style="font-size:12pt;" placeholder="Search by Genre">
			<input type="text" name="TBSearchRating" style="font-size:12pt;" placeholder="Search by Rating">
			<input type="text" name="TBSearchYear" style="font-size:12pt;" placeholder="Search by Year"><p>
			
			<input title = "Click to Search movies" type="submit" name = "BtnAdvancedSearch" id="BtnAdvancedSearch" value = "Search"><br><br><br>
		</form>
		
		<form class="client-form" action="MostLiked.php" method="post">
			<h2>Top ten most liked movies</h2>
			<input title = "Click to view top 10 most liked movies" type="submit" value="Go" ><br><br>
		</form>
		';

		//search button method
		if(isset($_POST['BtnSearch'])){
			//variable for the search word
			$target = $_POST['TBSearch'];
			$query = "SELECT * FROM `moviesrental_table` WHERE CONCAT(`ID`, 
			`Title`, 
			`Studio`,
			`Status`, 
			`Sound`, 
			`Versions`, 
			`RecRetPrice`, 
			`Rating`,
			`Year`, 
			`Genre`, 
			`Aspect`) LIKE '%".$target."%'" ;
			//use the method to execute the query variable
			$searchResult = searchTable($query);
			
			//block of code to show how many rows there are that the user had searched and displays a message if it has 0 results.
			if($results = searchTable($query))
			{
				$rowCount = mysqli_num_rows($results);
				printf("Results shows %d movie(s).\n", $rowCount);
				
				if($rowCount == 0){
					echo "<br>Error: No results found for your search.";
				}
			}
			
		}else{
			//Default webpage if the user has not clicked
			$query = "SELECT * FROM moviesrental_table";
			$searchResult = searchTable($query);
		}
		
		//database output
		?>
		<form action = "clientPage.php" method = "get">
			<table style='border: solid 1px black; border-collapse:collapse;'>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Studio</th>
					<th>Status</th>
					<th>Sound</th>
					<th>Versions</th>
					<th>RRP</th>
					<th>Rating</th>
					<th>Year</th>
					<th>Genre</th>
					<th>Aspect</th>
					<th>Likes</th>
					<th>Dislikes</th>
				</tr>
				
				<!-- populate table from database -->
				<?php while($row = $searchResult->fetch_assoc()):
					$rowID = $row['ID'];
				?>
				<tr>
					<td><?php echo $row['ID'];?></td>
					<td><?php echo $row['Title'];?></td>
					<td><?php echo $row['Studio'];?></td>
					<td><?php echo $row['Status'];?></td>
					<td><?php echo $row['Sound'];?></td>
					<td><?php echo $row['Versions'];?></td>
					<td><?php echo $row['RecRetPrice'];?></td>
					<td><?php echo $row['Rating'];?></td>
					<td><?php echo $row['Year'];?></td>
					<td><?php echo $row['Genre'];?></td>
					<td><?php echo $row['Aspect'];?></td>
					<?php
					echo"
						<td><a href=clientPage.php?Like='$rowID'>Like</a></td>
						<td><a href=clientPage.php?Dislike='$rowID'>Dislike</a></td>
					";
					?>
				</tr>
				<?php endwhile;?>
			</table>		
		</form>
		<?php
		
		//if clicked on like
		if (isset($_GET['Like'])) {
			$likeValue = $_GET['Like'];
			
			//update to database
			$query = ("UPDATE moviesrental_table SET Likes = Likes + 1 WHERE ID = $likeValue");
			if ($conn->query($query) === true) {
				echo "Record updated";
			} else {
				echo "Error: record not updated " . $conn->error;
			}
		}
		
		// if clicked on dislike
		if (isset($_GET['Dislike'])) {
			$disLikeValue = $_GET['Dislike'];
			
			//update to database
			$query = ("UPDATE moviesrental_table SET Dislikes = Dislikes + 1 WHERE ID = $disLikeValue");
			if ($conn->query($query) === true) {
				echo "Record updated";
			} else {
				echo "Error: record not updated" . $conn->error;
			}
		}		
		
		echo '
			<p><p><p>
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
			<input type="text" placeholder="Bob" name="Name" required>
		</div>
		<div>
			<label>Email</label>
			<input type="text" placeholder="Bob@gmail.com" name="Email" required>
		</div>
		<div>
			<label>Password</label>
			<input type="password" placeholder="P@ssw0rd" name="Password" required>
		</div>
		<button title = "Click to signup" type="submit">Signup</button>
	</form>

	<form class="client-form" action="login.inc.php" method="post">
		<div>
			<label>Email</label>
			<input type="text" placeholder="Bob@gmail.com" name="Email" required>
		</div>
		<div>
			<label>Password</label>
			<input type="password" placeholder="P@ssw0rd" name="Password" required>
		</div>
		<button title = "Click to login" type="submit">Login</button>
	</form>
		';
	}

	//Method to connect and execute the query
	function searchTable($f_query){
		//connect to database
		$f_connect = mysqli_connect("localhost", "root", "", "smtmoviesrental");
		//execute query from the connection
		$f_search = mysqli_query($f_connect, $f_query);
		return $f_search;
	}
	

?>

</body>
</html>

