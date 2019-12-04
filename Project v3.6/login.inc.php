<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 Version 1.2: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier
 
 Copyright to Acme Entertainment Pty Ltd
-->
<?php
$email = $_POST['Email'];
$password = $_POST['Password'];

$conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

if (!$conn) {
    die("Connection to servers failed. Error: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `users` WHERE `Email`=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: clientPage.php?error=sqlerror");
    exit();
}else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['Password']);
        if($pwdCheck == false) {
            header("Location: clientPage.php?error=error");
            exit();
        }
        else if($pwdCheck == true) {
                session_start();
                $_SESSION['user_id'] = $row['Email'];
                $_SESSION['user_fName'] = $row['fName'];
                $_SESSION['user_pLevel'] = $row['pLevel'];
                header("Location: clientPage.php?login=success");
                exit();
        }
    }else {
        header("Location: clientPage.php?error=nouser");
    }
}
?>