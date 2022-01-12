<?php
$servername = "localhost";
$username = "u480905865__afDev";
$password = "a1B@R]sF";
$dbname = "u480905865__personalDev";

// get the q parameter from URL
$q = $_REQUEST["id"];


$mysqli = new mysqli($servername, $username, $password, $dbname);
if($mysqli->connect_error) {
  exit('Could not connect..');
}

$sql = "SELECT strain, origin, startDate, harvestDate, harvestYield, status, growMedium, growLocation, comments
FROM `ectorGrow_plants` WHERE `status` = 'Flower' ";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_GET['id']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($strain, $origin, $startDate, $harvestDate, $harvestYield, $status, $growMedium, $growLocation, $comments);
$stmt->fetch();
$stmt->close();

echo "<table>";
echo "<tr>";
echo "<th>Strain Name</th>";
echo "<td>" . $strain . "</td>";
echo "<th>Origin</th>";
echo "<td>" . $origin . "</td>";
// echo "<th>ContactName</th>";
// echo "<td>" . $name . "</td>";
// echo "<th>Address</th>";
// echo "<td>" . $adr . "</td>";
// echo "<th>City</th>";
// echo "<td>" . $city . "</td>";
// echo "<th>PostalCode</th>";
// echo "<td>" . $pcode . "</td>";
// echo "<th>Country</th>";
// echo "<td>" . $country . "</td>";
echo "</tr>";
echo "</table>";
?>



<!--
// Array with names
$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";

// get the q parameter from URL
$q = $_REQUEST["id"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint; -->
