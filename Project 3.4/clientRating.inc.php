<?php
session_start();
$userEmail = $_SESSION['user_id'];
$mID = $_POST['MID'];
$sRating = $_POST['SRating'];
$userID = "";

$conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

if (!$conn) {
    die("Connection to servers failed. Error: " . mysqli_connect_error());
}


$sql = "SELECT * FROM users WHERE Email=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: clientPage.php?rating=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        $userID = $row['ID'];
    }else{
        header("Location: clientPage.php?rating=nouser");
    }
}


$sql = "INSERT INTO moviesrating (movieID, Rating, userID) VALUES (?,?,?)";
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: clientPage.php?rating=sqlerror");
}else {
    mysqli_stmt_bind_param($stmt, "sss", $mID, $sRating, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);    
    header("Location: clientPage.php?rating=Rated");
    exit();
}

?>