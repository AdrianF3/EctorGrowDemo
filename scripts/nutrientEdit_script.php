<?php

//Update data in DB
$plantID = $_POST['plantID']; //
$strainUP = $_POST['strainUpdate']; //
$originUP = $_POST['originUpdate']; //
$startDateUP = $_POST['startDateUpdate']; //
$transferDateUP = $_POST['transferDateUpdate'];
$statusUP = $_POST['statusUpdate']; //
$growMediumUP = $_POST['growMediumUpdate']; //
$growLocationUP = $_POST['growLocationUpdate']; //
$harvestDateUP = $_POST['harvestDateUpdate'];
$harvestYieldUP = $_POST['harvestYieldUpdate'];
$commentsUP = $_POST['commentsUpdate'];




include('../config.php');

$sql = "UPDATE `ectorGrow_plants` SET
`strain` = '$strainUP',
`origin` = '$originUP',
`startDate` = '$startDateUP',
`transferDate` = '$transferDateUP',
`harvestDate` = '$harvestDateUP',
`harvestYield` = '$harvestYieldUP',
`status` = '$statusUP',
`growMedium` = '$growMediumUP',
`growLocation` = '$growLocationUP',
`comments` = '$commentsUP'
WHERE `ectorGrow_plants`.`plantID` = '$plantID'"; //working

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully - redirecting";
  echo "<meta http-equiv='refresh' content='0; URL=http://ectorgrow.com/myplants.php' />";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
