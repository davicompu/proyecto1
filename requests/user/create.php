<?php
require("../database.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $data = json_decode(file_get_contents("php://input"));
  $username = mysql_real_escape_string($data->username);
  $password = mysql_real_escape_string($data->password);
  $firstname = mysql_real_escape_string($data->firstname);
  $lastname = mysql_real_escape_string($data->lastname);
  $age = mysql_real_escape_string($data->age);

  $connection=init_database();


  $sql = "INSERT INTO users (username, password, firstname,lastname,age) VALUES ('$username', '$password', '$firstname','$lastname','$age')";
  //print $sql;
  if ($connection->query($sql) === TRUE) {
    $status="CREATED";
    $response=array('status'=>$status);
    print json_encode($response);
  } else {
    $error=$connection->errno;
    //print_r($connection);
    if($error==1062){
      $status="DUPLICATED";
      $response=array('status'=>$status);
      print json_encode($response);
    }
    else{
      $response=array('status'=>$error);
      print json_encode($response);
    }
  }

  close_database($connection);
}
?>
