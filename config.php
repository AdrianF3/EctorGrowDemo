<?php
//Load DB Connection and gather current info
$servername = "localhost";
$username = "u480905865__afDev";
$password = "DhE1az6|Xb";
$dbname = "u480905865__personalDev";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// echo "config called";
