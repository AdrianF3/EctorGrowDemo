<?php
include 'scripts/phpFunctions.php';
// sessionCheck();
// Initialize the session
session_start();

if (isset($_POST["imgSubmit"])) {
  echo "img submit called. ";

}


include 'content/head.html';
include 'content/header.html';
include 'content/dev_content.html';
include 'content/footer.html';


 ?>
