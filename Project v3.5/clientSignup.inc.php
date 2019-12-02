<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 Version 1.2: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier
 
 Copyright to Acme Entertainment Pty Ltd
-->
<?php
$name = $_POST['Name'];
$email = $_POST['Email'];
$password = $_POST['Password'];

$conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

if (!$conn) {
    die("Connection to servers failed. Error: " . mysqli_connect_error());
}

    $sql = "SELECT Email FROM users WHERE Email=?";
    $stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: clientPage.php?error=sqlerror");
    exit();
}else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
    if($resultCheck > 0) {
        header("Location: clientPage.php?error=usertaken");
        exit();
    }else {
        $sql = "INSERT INTO users (fName, Email, Password, pLevel) VALUES (?,?,?,1)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: clientPage.php?error=sqlerror");
            exit();
        }else {
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPwd);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            header("Location: clientPage.php?create=success");
            exit();
        }
    }
}
    mysqli_stmt_close($stmt);
?>