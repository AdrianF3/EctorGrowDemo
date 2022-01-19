<?php

//Update data in DB
$plantID = $_POST['plantID']; //
$growLocationUP = $_POST['growLocationUpdate'];
$statusUP = $_POST['statusUpdate']; //
$harvestDateUP = $_POST['harvestDate']; //
$yield = $_POST['yield']; //
$commentsUP = $_POST['commentsUpdate'];




include('../config.php');

$sql = "UPDATE `ectorGrow_plants` SET
`growLocation` = '$growLocationUP',
`status` = '$statusUP',
`harvestDate` = '$harvestDateUP',
`harvestYield` = '$yield',
`comments` = '$commentsUP'
WHERE `ectorGrow_plants`.`plantID` = '$plantID'"; //working

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully - redirecting";
  echo "<meta http-equiv='refresh' content='1; URL=http://ectorgrowv1.afwebdev.com/harvested.php' />";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
