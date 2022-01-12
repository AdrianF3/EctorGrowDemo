<?php
include 'scripts/phpFunctions.php';
//Check if logged in, display userID
sessionCheck();
// $al = accessLvlCheck();
// echo "Just to confirm the access level is: " . $al;


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

//called if user adds new strain
if (isset($_POST['submitNewStrain'])) {
  $newStrain =  "|" . $_POST['newStrain'];
  $newSeeds = $seeds;
  $newString .= $newStrain;
  // echo "This is what I will pass." . $newString;
  // echo $seeds; can be used later to skip read statement and just append here
  // $uID = global $userID;
  addNewStrain($newStrain);
}

//called if user adds new grow location
if (isset($_POST['submitNewGrowLocation'])) {
  $newGrowLocation =  "|" . $_POST['newGrowLocation'];
  $newGrows = $growLocations;
  $newString .= $newGrows;
  // echo "This is what I will pass." . $newString;
  // echo $seeds; can be used later to skip read statement and just append here
  // $uID = global $userID;
  addNewGrow($newGrowLocation);
}

//called if user deletes a strain
if (isset($_POST['deleteSeedString'])) {
  $seedToDelete = $_POST['seedDelete'];
  $curSeedString = $seeds;
  $curSeedArr = explode("|", $curSeedString);
  //find string in array and remove it
  // echo "Looking to delete: " . $seedToDelete . " from: " . $curSeedString . "<br>";

  $index = array_search($seedToDelete, $curSeedArr);
  if($index !== FALSE){
      unset($curSeedArr[$index]);
  }

  $newString = implode("|", $curSeedArr);
  // echo "The new string after deleing is: " . $newString;

  updateSeeds($newString);
}

//called if user deletes a grow location
if (isset($_POST['deleteGrowString'])) {
  $growToDelete = $_POST['growDelete'];
  $curGrowString = $growLocations;
  $curGrowArr = explode("|", $curGrowString);
  //find string in array and remove it
  // echo "Looking to delete: " . $seedToDelete . " from: " . $curSeedString . "<br>";

  $index = array_search($growToDelete, $curGrowArr);
  if($index !== FALSE){
      unset($curGrowArr[$index]);
  }

  $newString = implode("|", $curGrowArr);
  // echo "The new string after deleing is: " . $newString;

  updateGrowLocations($newString);
}

// include 'scripts/phpFunctions.php';
include 'content/head.html';
include 'content/header.html';
include 'content/profile_content.html';
include 'content/footer.html';


 ?>
