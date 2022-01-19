<?php
//remove cookie, from previous build, this code should be removed no earlier than 9/1/21
if (isset($_COOKIE['userID'])) {
    unset($_COOKIE['userID']);
    setcookie('userID', null, -1, '/');

}

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
// header("location: login2.php");
echo "<meta http-equiv='refresh' content='0; URL=http://ectorgrowv1.afwebdev.com/login.php' />";
exit;
?>
