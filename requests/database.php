<?php
/*
The database.php is intended to save credentials to later return a msqli connection object.
*/
function init_database(){ //function that returns the connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "proyecto";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
return $conn;
}


function close_database($conn){//function that closes the connection passed as parameter
$conn->close();
}


?>
