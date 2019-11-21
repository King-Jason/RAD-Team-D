<!--
Version 1 : Original Document : Christina Tatang
Version 2.1: Made website responsive : Jason King
Version 3 : Made membership page and administrative functions : Christina Tatang
//-->
<!DOCTYPE html>
<!--
Name: Christina Tatang
ID: 30003663
DoB: 02/08/2000
Web Programming - Project 
-->

<!--php code--> 
<?php
//reference css file
echo "<link rel = 'stylesheet' type='text/css' href='Project.css'/> <meta charset ='utf-8'/>";

$username = 'root';
$password = '';
try 
{
    $conn = new PDO('mysql:host=localhost;dbname=smtmoviesrental', $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT `Latest`, COUNT(*) AS "Count" FROM `movies_latest` GROUP BY `Latest`');
    $stmt->execute();
    $i =0;
        
    $myArray = Array();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch()){
        
        $Latest = $row["Latest"];
        $Count = $row["Count"];
        $myArray[$i]['Latest'] = $row["Latest"];
        $myArray[$i]['Count'] = $row["Count"];
        $i++;
    }
    function cmp($a, $b)
    {
        return strcmp($b['Count'], $a['Count']);
    }
    usort($myArray, "cmp");
    
}
catch(PDOException $e) 
{
    echo 'ERROR: ' . $e->getMessage();
}
$conn = null;
echo "</table>";
?>

<!doctype html>
<html>
<head> 
<title> Top 10 Most Searched </title>

<!-- reference css file-->
<link rel = "stylesheet" type="text/css" href="Project.css"/>
<meta charset ="utf-8"/>
</head>

<!--outputting the bar chart-->
<body>
    <div class ="center " >
    <h4>Top 10 Most Searched</h4>
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


</body>
</html>
