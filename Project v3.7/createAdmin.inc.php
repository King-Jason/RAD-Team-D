<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 Version 1.2: Minor php code convention fixes using PHP_CodeSniffer and PHP Beautifier : Kyle Cleofe
 
 Copyright to Acme Entertainment Pty Ltd
-->
<?php
$name = $_POST['Name'];
$email = $_POST['Email'];
$pLevel = $_POST['pLevel'];
$password = $_POST['Password'];

$conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

if (!$conn) {
    die("Connection to servers failed. Error: " . mysqli_connect_error());
}

// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    header("Location: AdminPanel.php?error=passwordstrength");
    //echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
}else{
    $sql = "SELECT Email FROM users WHERE Email=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: AdminPanel.php?error=sqlerror");
        exit();
    }else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0) {
            header("Location: AdminPanel.php?error=usertaken");
            exit();
        }else {
            $sql = "INSERT INTO users (fName, Email, Password, pLevel) VALUES (?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: AdminPanel.php?error=sqlerror");
                exit();
            }else {
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPwd, $pLevel);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                header("Location: AdminPanel.php?create=success");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
}

?>