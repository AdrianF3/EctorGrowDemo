<?php

//Update data in DB
$userID = $_POST['userID']; //
$fName = $_POST['fName']; //
$lName = $_POST['lName'];
// $email = $_POST['email']; //
$seeds = $_POST['seeds']; //
$growLocations = $_POST['growLocations'];

// echo "the user id is: " . $userID;

include('../config.php');

$sql = "UPDATE `ectorGrow_users` SET
`firstName` = '$fName',
`lastName` = '$lName',
`strains` = '$seeds',
`growLocations` = '$growLocations'
WHERE `userID` = '$userID'"; //working

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully - redirecting";
  echo "<meta http-equiv='refresh' content='0; URL=http://ectorgrow.com/profile.php' />";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
