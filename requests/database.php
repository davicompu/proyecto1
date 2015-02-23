<?php

function init_database(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "proyecto";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
return $conn;
}


function close_database($conn){
$conn->close();
}


?>
