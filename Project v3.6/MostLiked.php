<!--
 Version 1 : Original Document : Christina Tatang
 Version 1.1: Made website responsive: Jason King
 Version 2: Added top 10 most liked movies : Kyle Cleofe
 
 Copyright to Acme Entertainment Pty Ltd
//-->
<!DOCTYPE html>

<?php
	/**
	 * Reference css file
	 **/
	echo "<link rel = 'stylesheet' type='text/css' href='Project.css'/> <meta charset ='utf-8'/>";

	$username = 'root';
	$password = '';
	try 
	{
		$conn = new PDO('mysql:host=localhost;dbname=smtmoviesrental', $username, $password); 
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare('SELECT Title, Likes FROM moviesrental_table WHERE Likes > 0 ORDER BY Likes DESC');
		$stmt->execute();
		$i =0;
			
		$myArray = Array();
		// set the resulting array to associative
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		while ($row = $stmt->fetch()) {
			
			$Latest = $row["Title"];
			$Count = $row["Likes"];
			$myArray[$i]['Latest'] = $row["Title"];
			$myArray[$i]['Count'] = $row["Likes"];
			$i++;
		}
		/**function cmp($a, $b)
		{
			return strcmp($b['Count'], $a['Count']);
		}
		usort($myArray, "cmp");**/
    
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
	$conn = null;
?>
<html>
	<head> 
		<title> Top 10 Most Liked </title>

		<!-- reference css file-->
		<link rel = "stylesheet" type="text/css" href="Project.css"/>
		<meta charset ="utf-8"/>
	</head>
	
	<!--outputting the bar chart-->
	<body>
		<div class ="center " >
		<h4>Top 10 Most Liked</h4>
			<div class = "chartBox">
				<h5><?php echo $myArray[0]['Latest']; ?> </h5>
				<h5> <?php echo $myArray[0]['Count']; ?></h5>
				<div class = "chart" >
					<div class = "chart_percent" style="width:<?php echo $myArray[0]['Count']; ?>%"></div>
				</div>
			</div>

			<div class = "chartBox">
				<h5><?php echo $myArray[1]['Latest']; ?> </h5>
				<h5> <?php echo $myArray[1]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[1]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[2]['Latest']; ?></h5>
				<h5> <?php echo $myArray[2]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[2]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[3]['Latest']; ?></h5>
				<h5> <?php echo $myArray[3]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[3]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[4]['Latest']; ?></h5>
				<h5> <?php echo $myArray[4]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[4]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[5]['Latest']; ?></h5>
				<h5> <?php echo $myArray[5]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[5]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[6]['Latest']; ?></h5>
				<h5> <?php echo $myArray[6]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[6]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[7]['Latest']; ?></h5>
				<h5> <?php echo $myArray[7]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[7]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[8]['Latest']; ?></h5>
				<h5> <?php echo $myArray[8]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[8]['Count']; ?>%"></div>
				</div>
			</div>
			
			<div class = "chartBox">
				<h5><?php echo $myArray[9]['Latest']; ?></h5>
				<h5> <?php echo $myArray[9]['Count']; ?></h5>
				<div class = "chart">
					<div class = "chart_percent" style="width:<?php echo $myArray[9]['Count']; ?>%"></div>
				</div>
			</div>
		</div>
		<?php
		sleep(5);
		header("Refresh:0");
		?>
</body>

</html>