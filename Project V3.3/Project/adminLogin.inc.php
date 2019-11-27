<?php
$email = $_POST['Email'];
$password = $_POST['Password'];

$conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

if (!$conn) {
    die("Connection to servers failed. Error: " . mysqli_connect_error());
}

$sql = "SELECT * FROM `users` WHERE `Email`=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: AdminPanel.php?error=sqlerror");
    exit();
}else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        $pwdCheck = password_verify($password, $row['Password']);
        if($pwdCheck == false){
            header("Location: AdminPanel.php?error=error");
            exit();
        }
        else if($pwdCheck == true){
            if($row['pLevel'] > 1) {
                session_start();
                $_SESSION['user_id'] = $row['Email'];
                $_SESSION['user_fName'] = $row['fName'];
                $_SESSION['user_pLevel'] = $row['pLevel'];
                header("Location: AdminPanel.php?login=success");
                exit();
            }else {
                header("Location: index.html");
            }

        }
    }else {
        header("Location: AdminPanel.php?error=nouser");
    }
}
?>