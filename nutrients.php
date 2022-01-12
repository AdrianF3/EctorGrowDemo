<?php
include 'scripts/phpFunctions.php';
sessionCheck();

//retrieve data to load page
include('config.php');
global $userID;
$sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $nutrients = $row["nutrients"];
  }
} else {
  echo "error";
}

$conn->close();



//test decoding json obj
$obj = json_decode($nutrients);
//set up variables and array for display
$growSize = $obj->defaultGrowSize;
$nute1 = $obj->nutrient1;
$nute2 = $obj->nutrient2;
$nute3 = $obj->nutrient3;
$nute4 = $obj->nutrient4;
$nute5 = $obj->nutrient5;


include 'content/head.html';
include 'content/header.html';
include 'content/nutrient_content.html';
include 'content/footer.html';


 ?>
