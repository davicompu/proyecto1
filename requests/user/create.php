<?php
require("../database.php"); //Importing the Database.php to get our connection to the database



if ($_SERVER['REQUEST_METHOD'] === 'POST') { //checking that the request comes from a POST method
/*
Since we are using angular js and because of the header that this framework
produces when using its object $https we can't use the native object $_POST.

mysql_real_escape_string - is used to avoid at an initial phase sql injections.

*/
  $data = json_decode(file_get_contents("php://input")); //We use this line of code because $_POST comes empty
  $username = mysql_real_escape_string($data->username);//Getting the username value
  $password = mysql_real_escape_string($data->password);//Getting the passoword value
  $firstname = mysql_real_escape_string($data->firstname);//Getting the firstname value
  $lastname = mysql_real_escape_string($data->lastname);//Getting the lastname value
  $age = mysql_real_escape_string($data->age);//Getting the age value

  $connection=init_database();//We get the connection using the function from database.php


  $sql = "INSERT INTO users (username, password, firstname,lastname,age) VALUES ('$username', '$password', '$firstname','$lastname','$age')"; // SQL query to create
  //print $sql; //For debuggin purpouses
  if ($connection->query($sql) === TRUE) {//Check if the creation was successful
    $status="CREATED";//The message we are going to return to our AJAX response
    $response=array('status'=>$status);//Preparing our response object
    echo json_encode($response); //Encoding our response on json format and returning it by echo it
  } else {
    $error=$connection->errno;
    //print_r($connection);
    if($error==1062){// Looking for an specific error code that means duplicated key, to notify username repetition
      $status="DUPLICATED";//The message we are going to return to our AJAX response
      $response=array('status'=>$status);//Preparing our response object
      echo json_encode($response);//Encoding our response on json format and returning it by echo it
    }
    else{
      $response=array('status'=>$error); //we send the error text
      echo json_encode($response);//Encoding our response on json format and returning it by echo it
    }
  }

  close_database($connection);
}
?>
