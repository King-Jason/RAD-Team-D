<?php
$email = $_POST['Email'];
$cPassword = $_POST['CPassword'];
$nPassword = $_POST['NPassword'];

$conn = mysqli_connect('127.0.0.1:3306', 'root', '', 'smtmoviesrental');

if (!$conn) {
    die("Connection to servers failed. Error: " . mysqli_connect_error());
}

$uppercase = preg_match('@[A-Z]@', $nPassword);
$lowercase = preg_match('@[a-z]@', $nPassword);
$number    = preg_match('@[0-9]@', $nPassword);
$specialChars = preg_match('@[^\w]@', $nPassword);
if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($nPassword) < 8) {
    header("Location: AdminPanel.php?error=passwordstrength");
}else {
    $sql = "SELECT * FROM `users` WHERE `Email`=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: AdminPanel.php?error=sqlerror");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            $pwdCheck = password_verify($cPassword, $row['Password']);
            if($pwdCheck == false){
                header("Location: AdminPanel.php?error=error");
                exit();
            }
            else if($pwdCheck == true){
                $sql = "UPDATE users SET Password=? WHERE Email=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "There was an error!";
                }else {
                    $newPwdHash = password_hash($nPassword, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $email);
                    mysqli_stmt_execute($stmt);
                    header("Location: AdminPanel.php?reset=success");
                }
            }
        }else {
            header("Location: AdminPanel.php?error=nouser");
        }
    }
}
    


?>