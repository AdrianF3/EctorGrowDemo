<?php
if(!isset($_SESSION["id"])) {
  //Display Nothing
} else {


  //Plans for V2 footer function
  // - get current year (YYYY)
  $currentYearDate = new DateTime();
  $currentYearDate = date_format($currentYearDate, 'Y');
  // echo "The current year is: " . $currentYearDate;
  // - Create an empty array called harvestedTotal that will be used to accumulate
  //    the totals for the year
  $harvestedTotalArray = [];
  $annualHarvestTotal = 0;


  // - select all plants that...
  //  - have a matching userID AND
  //  - status = harvested
  include('config.php');
  $sql = "SELECT * FROM `ectorGrow_plants` WHERE `status` = 'Harvested' AND `userID` = '$userID'";
  $result = $conn->query($sql);

  // - Loop through all items and store in the $harvestTotals array,
  //   only if harvest date = harvested this year
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      //copy data during while loop
      $strain = $row["strain"];
      $harvestDate = $row["harvestDate"];
      $harvestYield = $row["harvestYield"];

      //new variable to get just the year of the harvest date
      $harvestDateYear = substr($harvestDate, 0, 4);
      //echo "The harvested year was " . $harvestDateYear . "<br>";

      // - Loop through the harvestedPlants array and add information to the harvestedTotal array
      if ($currentYearDate == $harvestDateYear) {
        // echo "We have a match! ";
        //check to see if the strain has already been saved
        if (array_key_exists($strain, $harvestedTotalArray)) {
          // echo " and this is NOT a new strain.<br>";
          //add strain to the harvest total last and increment the harvest yield
          $harvestedTotalArray[$strain] += $harvestYield;
          $annualHarvestTotal += $harvestYield;
        } else {
          // echo " and this is a new strain.<br>";
          //add strain to the harvest total last and include the harvest yield
          $harvestedTotalArray[$strain] = $harvestYield;
          $annualHarvestTotal += $harvestYield;
        }
      }


    }
  }
  $conn->close();

  //  - display overall totals as I do now.
  echo '<table class="annualTotalsTable tc">
    <tr>
      <th colspan="2"><h2>Harvest Totals for 2022</h2></th>
    </tr>
    <tr>
      <th>Strain</th>
      <th>Yield</th>
    </tr>';

    foreach($harvestedTotalArray as $x => $x_value) {
      echo "<tr>
        <td>" . $x . "</td>
        <td>" . $x_value . "g || " . round(($x_value / 28), 2) . "oz </td>
        </tr>";
    }
  echo "<b><tr>
    <td>Yield Totals</td>
    <td>" . $annualHarvestTotal . "g || " . round(($annualHarvestTotal / 28), 2) . "oz </td>
    </tr></b>";
  echo "</table>";
}

?>
