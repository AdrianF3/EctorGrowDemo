<?php

include('config.php');
  $sql = "SELECT * FROM `ectorGrow_plants` WHERE `status` = 'Harvested' AND `userID` = '$userID'";
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



      if(isset($startDate)) {
        $tempDate = new DateTime($startDate);
        $startDate = date_format($tempDate, 'F jS, Y');
      }
      if(isset($transferDate)) {
        $tempDate = new DateTime($transferDate);
        $transferDate = date_format($tempDate, 'F jS, Y');
      }
      if(isset($harvestDate)) {
        $tempDate = new DateTime($harvestDate);
        $harvestDate = date_format($tempDate, 'F jS, Y');
      }


      include 'components/harvested_plantCard.html';
    }
  }
$conn->close();



?>
