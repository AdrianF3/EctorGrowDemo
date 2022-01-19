<?php
session_start();
$userID = $_SESSION["id"];
// echo "user id is:" . $userID;
if (isset($_COOKIE['userID'])) {
  $oldUserID = $_COOKIE['userID'];

  // echo "oldUserID: " . $oldUserID;
  echo "If you are experiencing any issues, you may need to
    <a href='http://ectorgrowv1.afwebdev.com/scripts/logout.php'>log in again</a>";
  // code...
}
// $oldUserID = $_COOKIE['userID'];
// $oldUserID = $_COOKIE["userID"];
// echo "oldUserID: " . $oldUserID;

//test if logged in to new system
// $_SESSION["id"] = 1;
// $newUserID = $_SESSION["id"];
// echo "new user id is:" . $newUserID;

// $_SESSION["id"] = $userID;
// echo "forcing session ID to match user id";
// echo "workings";




function sessionCheck() {
  //Check if logged in, display userID
  global $userID;
  if(!isset($_SESSION["id"])) {
    //echo "Visitor is not logged in.";
    //redirect user to login page
    header("location: login.php");
  } else {
    // echo "userID is: " . $userID . "<br>";
  }
}


function isLoggedIn() {
  if(!isset($_SESSION["id"])) {
    echo "<a class='nav-link' href='http://ectorgrowv1.afwebdev.com/login.php'>Log-In</a>";
  } else {
    echo "<a class='nav-link' href='http://ectorgrowv1.afwebdev.com/login.php'>Log-Out</a>";
  }
}

function deletePlant($plantDeleteID) {
  include('config.php');
  $sql = "DELETE FROM `ectorGrow_plants` WHERE `plantID` = $plantDeleteID";
  if ($conn->query($sql) === TRUE) {
    //echo "Record deleted successfully for plantID: " . $plantDeleteID;
    echo "<meta http-equiv='refresh' content='1; URL=http://ectorgrowv1.afwebdev.com/myplants.php' />";
  } else {
    echo "Error deleting your plant from the databse - Error report-> " . $conn->error;
  }
  $conn->close();
}

function abandonPlant($plantAbandonID) {
  //echo "plant to abandon: " . $plantAbandonID;
  include('config.php');
  $sql = "UPDATE `ectorGrow_plants` SET
  `status` = 'Abandoned',
  `growLocation` = '',
  `comments` = '$commentsUP'
  WHERE `ectorGrow_plants`.`plantID` = '$plantAbandonID'"; //working

  if ($conn->query($sql) === TRUE) {
    //echo "Plant status successfully changed to 'Abandoned' - redirecting";
    echo "<meta http-equiv='refresh' content='1; URL=http://ectorgrowv1.afwebdev.com/myplants.php' />";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  $conn->close();
}

// function indivPlant($plantID, $userID) {
//   //load data from db for current plant into php variables
//   include('config.php');
//   $sql = "SELECT * FROM `ectorGrow_plants` WHERE `plantID` = $plantID AND `userID` = '$userID'";
//   $result = $conn->query($sql);
//    // print_r($array);
//   if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//       //copy order id to store in session
//       $plantID = $row["plantID"];
//       $strain = $row["strain"];
//       $origin = $row["origin"];
//       $startDate = $row["startDate"];
//       $transferDate = $row["transferDate"];
//       $harvestDate = $row["harvestDate"];
//       $harvestYield = $row["harvestYield"];
//       $status = $row["status"];
//       $growMedium = $row["growMedium"];
//       $growLocation = $row["growLocation"];
//       $comments = $row["comments"];
//     }
//     $conn->close();
//   }
// }

function plantAccessVer($plantIDCheck) {
  global $userID;
  include('config.php');
  $sql = "SELECT * FROM `ectorGrow_plants` WHERE `plantID` = '$plantIDCheck'";
  $result = $conn->query($sql);
   // print_r($array);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      //copy order id to store in session
      $plantUserID = $row["userID"];
    }
  }
  //check to see if the current user has access to the plant they are
  // attempting to edit
  if ($userID == $plantUserID) {
    // echo "Access to edit this plant is valid";
  } else {
    echo "Error - You do not have permission to edit this plant!";
    echo "<meta http-equiv='refresh' content='3; URL=http://ectorgrowv1.afwebdev.com/myplants.php' />";
  }
}

function accessLvlCheck() {
  global $userID;
  //Get users access level from DB
  include('config.php');
  $sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      //copy order id to store in session
      $userID = $row["userID"];
      $accessLevel = $row["accessLevel"];
    }
  }
  $conn->close();
  return $accessLevel;
}

function menuDisplay() {
  $accessLvl = accessLvlCheck();
  //Check is user is logged in - if they aren't direct to the login page
  //If they are logged in, check access level and display the appropriate menu
  //level 1 -> default or normal menu
  //level 4 -> admin menu
  if(!isset($_SESSION["id"])) {
    //echo "<meta http-equiv='refresh' content='3; URL=http://ectorgrowv1.afwebdev.com/login.php' />";
    include 'components/menu_1_nonuser.html';
  } else {
    //Display default menu
    if ($accessLvl == 1) {
      include 'components/menu_1_user.html';
    }
    //Display admin menu
    if ($accessLvl == 4) {
      include 'components/menu_4_admin.html';
    }
  }
}

function displayUserSeeds($seedStr) {
  if (!isset($seedStr)) {
    echo "
      <p class='alert alert-warning tc' role='alert'>Seeds Have Not Been Added To Your Profile Yet - Add One Below!
      </p>";
    // code...
    } else {
      $seedArr = explode("|", $seedStr);
      $arrLength = count($seedArr);

      echo "<table>
        <tr>
          <th colspan='2'></th>
        </tr>";
      //iterate through array, displaying user seeds
      for ($i=0; $i < $arrLength; $i++) {
        // echo "This is the strain: " . $seedArr[$i] . "<br>";
        echo "<tr>
          <td>" . $seedArr[$i] . "</td>
          <td>
            <form method='post' class='delForm'>
              <input type='text' name='seedDelete' value='" . $seedArr[$i] . "' hidden>
              <button type='submit' name='deleteSeedString'>
                <img src='img/delete.svg'>
              </button>
            </form>

          </td>
        </tr>";
    }
  }


  //option to add new strains
  echo "</table>
  <br>
  <form method='post'>
    <input type='text' name='newStrain' required;>
    <button type='submit' name='submitNewStrain'class='btn btn-warning'>
      New Seed
    </button>
  </form>
  ";
}

function displayUserGrowLocations($growStr) {
  if (!isset($growStr)) {
    // code...
    echo "
      <p class='alert alert-warning tc' role='alert'>No Grow Locations Have Been Added To Your Profile Yet - Add One Below!
      </p>";
  } else {
    // code...
    $growArr = explode("|", $growStr);
    $arrLength = count($growArr);

    echo "<table>
      <tr>
        <th colspan='2'></th>
      </tr>";
    //iterate through array, displaying user seeds
    for ($i=0; $i < $arrLength; $i++) {
      // echo "This is the strain: " . $seedArr[$i] . "<br>";
      echo "<tr>
        <td>" . $growArr[$i] . "</td>
        <td>
          <form method='post' class='delForm'>
            <input type='text' name='growDelete' value='" . $growArr[$i] . "' hidden>
            <button type='submit' name='deleteGrowString'>
              <img src='img/delete.svg'>
            </button>
          </form>

        </td>
      </tr>";
    }
  }


    //option to add new strains
    echo "</table>
    <br>
    <form method='post'>
      <input type='text' name='newGrowLocation' required;>
      <button type='submit' name='submitNewGrowLocation'class='btn btn-warning'>
        New Grow Location
      </button>
    </form>
    ";


}

function addNewStrain($newStrain) {
  // echo "the new strain to add is: " . $newStrain . " and the user id is:" . $userID;
  global $userID;
  //Get users access level from DB
  include('config.php');
  //sql to append the item to the user seed field
  $sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $oldString = $row["seeds"];
      //append strings together
      $newString = $oldString;
      $newString .= $newStrain;
      // echo $newString;
    }
  } else {
    echo "error";
  }

  $sql = "UPDATE `ectorGrow_users` SET seeds='$newString' WHERE `userID` = '$userID'";

  if ($conn->query($sql) === TRUE) {
    echo "<meta http-equiv='refresh' content='0'>";
  } else {
    echo "Error updating record: " . $conn->error;
  }


  $conn->close();
}

function addNewGrow($newGrowLocation) {
  // echo "the new strain to add is: " . $newStrain . " and the user id is:" . $userID;
  global $userID;
  //Get users access level from DB
  include('config.php');
  //sql to append the item to the user seed field
  $sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $oldString = $row["growLocations"];
      //append strings together
      $newString = $oldString;
      $newString .= $newGrowLocation;
      // echo $newString;
    }
  } else {
    echo "error";
  }

  $sql = "UPDATE `ectorGrow_users` SET growLocations='$newString' WHERE `userID` = '$userID'";

  if ($conn->query($sql) === TRUE) {
    echo "<meta http-equiv='refresh' content='0'>";
  } else {
    echo "Error updating record: " . $conn->error;
  }


  $conn->close();
}

function updateSeeds($newString) {
  global $userID;
  //Get users access level from DB
  include('config.php');

  $sql = "UPDATE `ectorGrow_users` SET seeds='$newString' WHERE `userID` = '$userID'";

  if ($conn->query($sql) === TRUE) {
    echo "<meta http-equiv='refresh' content='0'>";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  $conn->close();
}

function updateGrowLocations($newString) {
  global $userID;
  //Get users access level from DB
  include('config.php');

  $sql = "UPDATE `ectorGrow_users` SET growLocations='$newString' WHERE `userID` = '$userID'";

  if ($conn->query($sql) === TRUE) {
    echo "<meta http-equiv='refresh' content='0'>";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  $conn->close();
}

function displayUserSeedsForm() {
  global $userID;
  //Get users access level from DB
  include('config.php');
  //sql to append the item to the user seed field
  $sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $seedString = $row["seeds"];
      $seedArr = explode("|", $seedString);
      $arrLength = count($seedArr);

      for ($i=0; $i < $arrLength; $i++) {
        echo "<option value='" . $seedArr[$i] . "'>" . $seedArr[$i] . "</option>";
      }


      // echo $newString;
    }
  } else {
    echo "error";
  }
  $conn->close();
}

function displayUserGrowLocationsForm() {
  global $userID;
  //Get users access level from DB
  include('config.php');
  //sql to append the item to the user seed field
  $sql = "SELECT * FROM `ectorGrow_users` WHERE `userID` = '$userID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $growString = $row["growLocations"];
      $growArr = explode("|", $growString);
      $arrLength = count($growArr);

      for ($i=0; $i < $arrLength; $i++) {
        echo "<option value='" . $growArr[$i] . "'>" . $growArr[$i] . "</option>";
      }


      // echo $newString;
    }
  } else {
    echo "error";
  }
  $conn->close();
}

function logUserIn($email) {
  echo $email;
  include 'config.php';

  //sql to retrive user id by email address
  $sql = "SELECT * FROM `ectorGrow_users` WHERE `email` = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["userID"];
      $username = $row["username"];

      session_start();
      $_SESSION["loggedin"] = true;
      $_SESSION["id"] = $id;
      $_SESSION["username"] = $username;
      echo "user logged in";
    }
  } else {
    echo "error logging user in";
  }
  $conn->close();
}

function vegNutrientDisplay($plantID, $strain, $status, $startDate, $growLocation) {
  //Calculate days since start or transfer
  $date1=date_create("$startDate");
  $date2=date_create("$currentDate");
  $diff=date_diff($date1,$date2);
  $numDays = $diff->format("%a");


  //While Week 1 Veg
  if ($numDays <= 7) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . "<br> ";
    echo "<script>
      document.getElementById('week_1').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 2 Veg
  if ($numDays >= 8 & $numDays <= 14) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . "<br> ";
    echo "<script>
      document.getElementById('week_2').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 3 Veg
  if ($numDays >= 15) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . "<br> ";
    // $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
    echo "<script>
      document.getElementById('week_3').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
}

function flowerNutrientDisplay($plantID, $strain, $status, $transferDate, $growLocation) {
  //echo "flowerNutrientFunction Called!<br>";
  //Calculate days since start or transfer
  $date1=date_create("$transferDate");
  $date2=date_create("$currentDate");
  $diff=date_diff($date1,$date2);
  $numDays = $diff->format("%a");

  //While Week 4 Flower
  if ($numDays <= 7) {
    // $msg = $strain . " - Growing at " . $growLocation .  " ID:" . $plantID . "<br> ";
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_4').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 5 Flower
  if ($numDays >= 8 & $numDays <= 14) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_5').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 6 Flower
  if ($numDays >= 15 & $numDays <= 21) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_6').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 7 Flower
  if ($numDays >= 22 & $numDays <= 28) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_7').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 8 Flower
  if ($numDays >= 29 & $numDays <= 35) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_8').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 9 Flower
  if ($numDays >= 36 & $numDays <= 42) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_9').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 10 Flower
  if ($numDays >= 43 & $numDays <= 49) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_10').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 11 Flower
  if ($numDays >= 50 & $numDays <= 56) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_11').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
  //While Week 12 Flower
  if ($numDays >= 57) {
    $msg = $strain . " - Growing at " . $growLocation .  " Day: " . $numDays . " of flower<br> ";
    echo "<script>
      document.getElementById('week_12').innerHTML += '" . $msg  . "';
      var prevMsg = document.getElementById('week_2').innerHTML;
    </script>";
  }
}

function calculateDays() {
  //Generate Current Date
  $currentDate = new DateTime();
  $currentDate = date_format($currentDate, 'Y-m-d');
  global $userID;
  // echo "current date is: " . $currentDate . "<br>";

  //Grab Plant Data -> plantID, strain, status, startDate or transferDate
  //Save Data to array
  include('config.php');
  $sql = "SELECT * FROM `ectorGrow_plants` WHERE `status` != 'Harvested'";
  // $sql = "SELECT * FROM `ectorGrow_plants` WHERE `userID` = '$userID'";
  // $sql = "SELECT * FROM `ectorGrow_plants` WHERE `status` != 'Harvested' AND `userID` = '$userID'";
  $result = $conn->query($sql);
  // var_dump($result);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      //copy order id to store in session
      $plantUserId = $row["userID"];
      $plantID = $row["plantID"];
      $strain = $row["strain"];
      $status = $row["status"];
      $startDate = $row["startDate"];
      $transferDate = $row["transferDate"];
      $growLocation = $row["growLocation"];
      //foreach index in array -> check if in Veg or in Flower,
      //if veg call vegNutrientFunction, if flower call flowerNutrientFunction


      // echo "plant user id is: ". $plantUserId . " and the logged in user id is " . $userID . "<br>";
      if ($plantUserId == $userID) {
        // code...
        if ($status == "Veg") {
          vegNutrientDisplay($plantID, $strain, $status, $startDate, $growLocation);
        }
        if ($status == "Flower") {
          flowerNutrientDisplay($plantID, $strain, $status, $transferDate, $growLocation);
        }
      }
    }
  }
  $conn->close();
}

//New functiuon for outputting user nutrients, in development
function userNutrientDisplay() {
  global $growSize,$nute1,$nute2,$nute3,$nute4,$nute5;


  for ($i=1; $i < count($nute1); $i++) {
    //echo "<br>here is the value of nute1" . $nute1[$i];
    echo "<tr>";
    echo "<td>Week " . $i . "</td>";
    echo "<td>" . $nute1[$i] . "</td>";
    echo "<td>" . $nute2[$i] . "</td>";
    echo "<td>" . $nute3[$i] . "</td>";
    echo "<td>" . $nute4[$i] . "</td>";
    echo "<td>" . $nute5[$i] . "</td>";
    echo "<td id=" . "week_" . $i . "></td>";
    // echo "<td id=" . "week_" . ($i + 1) . "></td>";

    echo "</tr>";
  }

  // echo "this is testing page " . $growSize;
  //example of displaying value in array
  //echo "nute one is: " . $nute1[0];
}

//New functiuon for outputting user nutrients, in development
function userNutrientDisplayEdit() {
  global $growSize,$nute1,$nute2,$nute3,$nute4,$nute5;


  for ($i=1; $i < count($nute1); $i++) {
    //echo "<br>here is the value of nute1" . $nute1[$i];
    echo "<tr>";
    echo "<td>Week " . $i . "</td>";
    echo "<td><input type='number' class='numField' value='" . $nute1[$i] . "' name='1_" . $i . "'></td>";
    echo "<td><input type='number' class='numField' value='" . $nute2[$i] . "' name='2_" . $i . "'></td>";
    echo "<td><input type='number' class='numField' value='" . $nute3[$i] . "' name='3_" . $i . "'></td>";
    echo "<td><input type='number' class='numField' value='" . $nute4[$i] . "' name='4_" . $i . "'></td>";
    echo "<td><input type='number' class='numField' value='" . $nute5[$i] . "' name='5_" . $i . "'></td>";
    echo "<td id=" . "week_" . ($i + 1) . "></td>";

    echo "</tr>";
  }

}

function displayCardImgs() {

  //temporary Flags, has images
  // $img1, $img2, $img3 = 1;
  $img1 = $img2 = $img3 = 1;
  //temporary flags, has no images
  $img4 = $img5 = 0;
  // $img4, $img5 = 0;

  global $plantID;
  echo "<img src='img/IMG_1405.png' class='img-fluid' id='" . $plantID . "_main' alt='Responsive image'>";
  echo "<div class='plantImgThumbnails text-center'>";


  if ($img1) {
    // code...
    echo "<img src='img/IMG_1406.png' id='" . $plantID . "_1' alt='...' class='img-thumbnail'>";
  } else {
    // code...
    echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_1' alt='...' class='img-thumbnail'>";
  }

  if ($img2) {
    // code...
    echo "<img src='img/IMG_1524.png' id='" . $plantID . "_2' alt='...' class='img-thumbnail'>";
  } else {
    // code...
    echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_2' alt='...' class='img-thumbnail'>";
  }

  if ($img3) {
    // code...
    echo "<img src='img/IMG_1526.png' id='" . $plantID . "_3' alt='...' class='img-thumbnail'>";
  } else {
    // code...
    echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_3' alt='...' class='img-thumbnail'>";
  }

  if ($img4) {
    // code...
    echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_4' alt='...' class='img-thumbnail'>";
  } else {
    // code...
    echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_4' alt='Click to add an image' class='img-thumbnail'>";
  }

  if ($img5) {
    // code...
    echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_5a' alt='...' class='img-thumbnail'>";
  } else {
    // code...
    // echo "<img src='img/cameraPlus.svg' id='" . $plantID . "_5' alt='Click to add an image' class='img-thumbnail'>";
    echo "<form method='POST'>";
    echo "<input type='image' src='img/cameraPlus.svg' id='" . $plantID . "_5b' class='img-thumbnail' name='imgSubmit'>";
    echo "</form>";
  }

  echo "</div>";
}
