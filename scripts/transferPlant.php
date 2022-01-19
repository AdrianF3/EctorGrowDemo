<?php

//Update data in DB
$plantID = $_POST['plantID']; //
$transferDateUP = $_POST['transferDateUpdate'];
$statusUP = $_POST['statusUpdate']; //
$growLocationUP = $_POST['growLocationUpdate']; //
$commentsUP = $_POST['commentsUpdate'];




include('../config.php');

$sql = "UPDATE `ectorGrow_plants` SET
`transferDate` = '$transferDateUP',
`status` = '$statusUP',
`growLocation` = '$growLocationUP',
`comments` = '$commentsUP'
WHERE `ectorGrow_plants`.`plantID` = '$plantID'"; //working

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully - redirecting";
  echo "<meta http-equiv='refresh' content='1; URL=http://ectorgrowv1.afwebdev.com/myplants.php' />";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
