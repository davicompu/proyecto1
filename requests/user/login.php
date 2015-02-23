<?php
require("../database.php");//Importing the Database.php to get our connection to the database



if ($_SERVER['REQUEST_METHOD'] === 'POST') {//checking that the request comes from a POST method
$connection=init_database(); //getting the connection from database.php
/*
Since we are using angular js and because of the header that this framework
produces when using its object $https we can't use the native object $_POST.

mysql_real_escape_string - is used to avoid at an initial phase sql injections.

*/
$data = json_decode(file_get_contents("php://input"));//We use this line of code because $_POST comes empty
$username = mysql_real_escape_string($data->username);//Getting the username value
$password = mysql_real_escape_string($data->password);//Getting the password value
$authenticated="PENDING";//default authentication flag

$sql = "SELECT firstname, lastname FROM users WHERE username='$username' AND password='$password' ;";//Query
$result = $connection->query($sql);//executing query
//echo "query: ".$sql;
if ($result->num_rows > 0) {//if founds at least one row it goes inside the if
  //echo "FOUND something";
    $r=array();//our user array
    //print_r($result);

    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        //filling the user array
        $r["username"]=$username;
        $r["firstname"]=$row["firstname"];
        $r["lastname"]=$row["lastname"];
    }
    $authenticated="FOUND";//Notifying that we found the user
    $response=array('authenticated'=>$authenticated,'user'=>$r);//sending the flag and the user
    echo json_encode($response);//enconding to json and echoing the response
} else {
    $authenticated="NOT_FOUND";//Notifying that we did not found the user
    $response=array('authenticated'=>$authenticated); //sending only the flag
    echo json_encode($response);//enconding to json and echoing the response
}
 close_database($connection);//closing the connection
}
?>
