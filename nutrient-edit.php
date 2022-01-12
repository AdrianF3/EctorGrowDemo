<?php
include 'scripts/phpFunctions.php';
sessionCheck();

//Load content for page
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


//if btn is clicked to submit edits
if (isset($_POST['nutrientSubmit'])) {
  //Need to recieve array and rebuild the arrays to build the object to
  //save back to the database

  //create empty arrays
  $rNute1 = $rNute2 = $rNute3 = $rNute4 = $rNute5 = [];
  // $rGrowSize = 0; //come back and complete this

  //load content back into arrays
  //loop 13 times, for every week
  for ($i=0; $i < 13; $i++) {
    //loop 5 times for the different nutrients
    for ($b=1; $b <= 5; $b++) {
      //Load data for current item
      $tempLoc = $b . "_" . $i;

      if ($b == 1) {
          $rNute1[$i] = $_POST[$tempLoc];
      }
      if ($b == 2) {
          $rNute2[$i] = $_POST[$tempLoc];
      }
      if ($b == 3) {
          $rNute3[$i] = $_POST[$tempLoc];
      }
      if ($b == 4) {
          $rNute4[$i] = $_POST[$tempLoc];
      }
      if ($b == 5) {
          $rNute5[$i] = $_POST[$tempLoc];
      }
    }
  }

  $updatedNutrientArray = new stdClass();
  $updatedNutrientArray->defaultGrowSize = 3;
  $updatedNutrientArray->nutrient1 = $rNute1;
  $updatedNutrientArray->nutrient2 = $rNute2;
  $updatedNutrientArray->nutrient3 = $rNute3;
  $updatedNutrientArray->nutrient4 = $rNute4;
  $updatedNutrientArray->nutrient5 = $rNute5;


  $updatedJSON = json_encode($updatedNutrientArray);
  global $userID;


  include('config.php');
  $sql = "UPDATE `ectorGrow_users` SET nutrients='$updatedJSON' WHERE userID='$userID'"; ;
  if ($conn->query($sql) === TRUE) {
    // echo "Nutrients successfully changed";
    echo "<meta http-equiv='refresh' content='1; URL=http://ectorgrow.com/nutrients.php' />";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  $conn->close();

}

include 'content/head.html';
include 'content/header.html';
include 'content/nutrient_edit.html';
include 'content/footer.html';


 ?>
