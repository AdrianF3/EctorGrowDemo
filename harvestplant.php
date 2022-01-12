<?php
include 'scripts/phpFunctions.php';
//Check if logged in, display userID
sessionCheck();

//recieve the plantID from the form
$plantID = $_POST['plantID'];
//check if user has access to this plant.
plantAccessVer($plantID);
//get todays date
$currentDate = new DateTime();
$currentDate = date_format($currentDate, 'Y-m-d');

//load data from db for current plant into php variables
include('config.php');
$sql = "SELECT * FROM `ectorGrow_plants` WHERE `plantID` = $plantID AND `userID` = '$userID'";
$result = $conn->query($sql);
 // print_r($array);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //copy order id to store in session
    $plantID = $row["plantID"];
    $strain = $row["strain"];
    $origin = $row["origin"];
    $startDate = $row["startDate"];
    $transferDate = $row["transferDate"];
    $harvestDate = $row["harvestDate"];
    $harvestYield = $row["harvestYield"];
    $status = $row["status"];
    $growMedium = $row["growMedium"];
    $growLocation = $row["growLocation"];
    $comments = $row["comments"];
  }
  $conn->close();
}



include 'content/head.html';
include 'content/header.html';
include 'content/harvestPlant.html';
include 'content/footer.html';


 ?>
