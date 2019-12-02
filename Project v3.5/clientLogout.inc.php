<!--
 Version 1: Original Document: php for checking password and starting sessions Jason King
 Version 1.1: Made website responsive : Jason King
 
 Copyright to Acme Entertainment Pty Ltd
-->
<?php
// Always start this first
session_start();

// Destroying the session clears the $_SESSION variable, thus "logging" the user
// out. This also happens automatically when the browser is closed
session_destroy();
header("Location: clientPage.php?logout=success");
?>