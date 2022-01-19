<?php
include 'scripts/phpFunctions.php';
//Check if logged in, display userID
sessionCheck();


if (isset($_POST['addPlant'])) {
  $strain = $_POST['strainInput'];
  $origin = $_POST['originInput'];
  $startDate = $_POST['startDateInput'];
  $status = $_POST['statusInput'];
  $growMedium = $_POST['growMediumInput'];
  $growLocation = $_POST['growLocationInput'];
  $harvestDate = $_POST['harvestDateInput'];
  $harvestYield = $_POST['harvestYieldInput'];
  $comments = $_POST['commentsInput'];

  include 'config.php';

  $sql = "INSERT INTO `ectorGrow_plants` (userID, strain, origin, startDate, harvestDate, harvestYield, status, growMedium, growLocation, comments) VALUES ('$userID', '$strain', '$origin', '$startDate', '$harvestDate', '$harvestYield', '$status', '$growMedium', '$growLocation', '$comments')";

  if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
    echo "<meta http-equiv='refresh' content='0; URL=http://ectorgrowv1.afwebdev.com/myplants.php' />";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

$conn->close();
}

include 'content/head.html';
include 'content/header.html';
include 'content/addPlant.html';
include 'content/footer.html';


 ?>
