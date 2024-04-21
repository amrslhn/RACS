<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$dbName = "racs";

// Create a connection to the database
$conn = new mysqli($hostName, $userName, $password, $dbName);
// if ($conn->ping()) {
//   echo "The database connection is alive.";
// } else {
//   echo "The database connection is not alive.";
// }
?>