<?php
include 'scripts/phpFunctions.php';
//Check if logged in, display userID
sessionCheck();


//load variables for current user
include('config.php');
$sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //copy order id to store in session
    $userID = $row["userID"];
    $fName = $row["firstName"];
    $lName = $row["lastName"];
    $email = $row["email"];
    $registered = $row["registered"];
    $accessLevel = $row["accessLevel"];
    $seeds = $row["seeds"];
    $growLocations = $row["growLocations"];
  }
}

$conn->close();

// include 'scripts/phpFunctions.php';
include 'content/head.html';
include 'content/header.html';
include 'content/editprofile_content.html';
include 'content/footer.html';


 ?>
