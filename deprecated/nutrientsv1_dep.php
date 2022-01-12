<?php

include 'scripts/phpFunctions.php';
//Check if logged in, display userID
sessionCheck();
//
// function calculateDays() {
//   //Generate Current Date
//   $currentDate = new DateTime();
//   $currentDate = date_format($currentDate, 'Y-m-d');
//   global $userID;
//   // echo "current date is: " . $currentDate . "<br>";
//
//   //Grab Plant Data -> plantID, strain, status, startDate or transferDate
//   //Save Data to array
//   include('config.php');
//   $sql = "SELECT * FROM `ectorGrow_plants` WHERE `status` != 'Harvested'";
//   // $sql = "SELECT * FROM `ectorGrow_plants` WHERE `userID` = '$userID'";
//   // $sql = "SELECT * FROM `ectorGrow_plants` WHERE `status` != 'Harvested' AND `userID` = '$userID'";
//   $result = $conn->query($sql);
//   // var_dump($result);
//   if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//       //copy order id to store in session
//       $plantUserId = $row["userID"];
//       $plantID = $row["plantID"];
//       $strain = $row["strain"];
//       $status = $row["status"];
//       $startDate = $row["startDate"];
//       $transferDate = $row["transferDate"];
//       $growLocation = $row["growLocation"];
//       //foreach index in array -> check if in Veg or in Flower,
//       //if veg call vegNutrientFunction, if flower call flowerNutrientFunction
//
//
//       // echo "plant user id is: ". $plantUserId . " and the logged in user id is " . $userID . "<br>";
//       if ($plantUserId == $userID) {
//         // code...
//         if ($status == "Veg") {
//           vegNutrientFunction($plantID, $strain, $status, $startDate, $growLocation);
//         }
//         if ($status == "Flower") {
//           flowerNutrientFunction($plantID, $strain, $status, $transferDate, $growLocation);
//         }
//       }
//     }
//   }
//   $conn->close();
// }
//
//
// function vegNutrientFunction($plantID, $strain, $status, $startDate, $growLocation) {
//   //Calculate days since start or transfer
//   $date1=date_create("$startDate");
//   $date2=date_create("$currentDate");
//   $diff=date_diff($date1,$date2);
//   $numDays = $diff->format("%a");
//
//   //While Week 1 Veg
//   if ($numDays <= 7) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_1').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 2 Veg
//   if ($numDays >= 8 & $numDays <= 14) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_2').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 3 Veg
//   if ($numDays >= 15) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_3').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
// }
//
//
//
// function flowerNutrientFunction($plantID, $strain, $status, $transferDate, $growLocation) {
//   //echo "flowerNutrientFunction Called!<br>";
//   //Calculate days since start or transfer
//   $date1=date_create("$transferDate");
//   $date2=date_create("$currentDate");
//   $diff=date_diff($date1,$date2);
//   $numDays = $diff->format("%a");
//
//   //While Week 4 Flower
//   if ($numDays <= 7) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_4').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 5 Flower
//   if ($numDays >= 8 & $numDays <= 14) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_5').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 6 Flower
//   if ($numDays >= 15 & $numDays <= 21) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_6').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 7 Flower
//   if ($numDays >= 22 & $numDays <= 28) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_7').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 8 Flower
//   if ($numDays >= 29 & $numDays <= 35) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_8').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 9 Flower
//   if ($numDays >= 36 & $numDays <= 42) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_9').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 10 Flower
//   if ($numDays >= 43 & $numDays <= 49) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_10').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 11 Flower
//   if ($numDays >= 50 & $numDays <= 56) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_11').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
//   //While Week 12 Flower
//   if ($numDays >= 57) {
//     $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
//     echo "<script>
//       document.getElementById('week_12').innerHTML += '" . $msg  . "';
//       var prevMsg = document.getElementById('week_2').innerHTML;
//     </script>";
//   }
// }



function nutrientOutput() {
  //Arrays for Nutrients
  $floraMicro = array(6, 12, 15, 12, 12, 12, 12, 12, 12, 7, 7, 0);
  $floraGro = array(3, 15, 15, 12, 3, 3, 3, 3, 0, 0, 0, 0);
  $floraBloom = array(3, 3, 7, 12, 15, 15, 18, 18, 24, 24, 24, 0);
  // $calMag = array(12, 9, 9, 8, 7, 7, 5, 5, 5, 5, 3, 0); //outdated
  $calMag = array(6, 7, 7, 7, 7, 7, 5, 5, 5, 5, 3, 0);

  $arrLength = count($floraMicro);

  for($x = 0; $x < $arrLength; $x++) {
    echo "<tr>";
    echo "<td>Week #" . ($x + 1) . "</td>";
    echo "<td>" . $floraMicro[$x] . "ml</td>";
    echo "<td>" . $floraGro[$x] . "ml</td>";
    echo "<td>" . $floraBloom[$x] . "ml</td>";
    echo "<td>" . $calMag[$x] . "ml</td>";
    echo "<td id=" . "week_" . ($x + 1) . "></td>";
    echo "</tr>";
  }
}

// include 'scripts/phpFunctions.php';
include 'content/head.html';
include 'content/header.html';
include 'content/nutrients_content.html';
include 'content/footer.html';


 ?>
