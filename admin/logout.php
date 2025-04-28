<?php
session_start();
unset($_SESSION['Admin_Username']);
session_destroy();
header("Location: ../index.php");
exit();
// Redirect to the login page after logout
header("Location: ./index.php"); 
exit();
?>