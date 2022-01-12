<?php
include 'scripts/phpFunctions.php';
//Check if logged in, display userID
sessionCheck();
//recieve plant ID from form
$plantID = $_POST['plantID'];
$strain = $_POST['strain'];

//check if user has access to this plant.
plantAccessVer($plantID);

//php event listener to call abandon or delete functiions
if (isset($_POST['deletePlant'])) {
  $plantID = $_POST['plantID'];
  deletePlant($plantID);
}

if (isset($_POST['abandonPlant'])) {
  $plantID = $_POST['plantID'];
  abandonPlant($plantID);
}

include 'content/head.html';
include 'content/header.html';
include 'content/deletePlant.html';
include 'content/footer.html';


 ?>
