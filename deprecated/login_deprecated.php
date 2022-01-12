<?php
include 'scripts/phpFunctions.php';
sessionCheck();



//Functionality to transfer plant from Veg to Flower
if (isset($_POST['login'])) {
  $email = $_POST['sub_email'];
  $password = $_POST['sub_password'];
  $tempP = $password;

  $lowerCaseEmail = strtolower($email);
  // echo $lowerCaseEmail;

  //validate user input

  //retrieve info from user based on email used
  include 'config.php';
  $sql = "SELECT * FROM `ectorGrow_users` WHERE email='$lowerCaseEmail'";

  //if they do, save sesssion ID and redirect to main page
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    //Collect data from retrieved info based on user provided email
    while($row = $result->fetch_assoc()) {
      $dbPassword = $row["password"];
      $userID = $row["userID"];

      //If passwords match, save session with userID
      //Check to see if passwords match, if not delete info and notify user
      if ($tempP == $dbPassword) {
        //save session with userID
        $cookieName = "userID";
        $cookieValue = $userID;
        //set cookie for 30 days
        setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");
        echo "<meta http-equiv='refresh' content='0; URL=http://ectorgrow.com/myplants.php' />";
      } else {
        //clear out variables
        unset($dbPassword);
        unset($password);
        echo "<br>Variables have been cleared - login failed - please try again\n";
      }
    }

  } else {
    echo "<br>Login Failed";
  }
  //if they do not match/ notify user and reload login page
}


include 'content/head.html';
include 'content/header.html';
include 'content/login_content.html';
include 'content/footer.html';


 ?>
