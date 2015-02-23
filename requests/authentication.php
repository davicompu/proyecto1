<?php
if($_POST){

}


public function init_database(){

  $servername = "localhost";
  $username = "username";
  $password = "password";
  $dbname = "myDB";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
return $conn;
}

public function close_database($connection){
  $connection->close();
}

?>
