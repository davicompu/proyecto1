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
$id = mysql_real_escape_string($data->id);//Getting the id value

$sql = "SELECT * FROM users WHERE id=$id ;";//Query
$result = $connection->query($sql);//executing query
//echo "query: ".$sql;
if ($result->num_rows > 0) {//if founds at least one row it goes inside the if
  //echo "FOUND something";
    $r=array();//our user array
    //print_r($result);

    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        //filling the user array
        $r["username"]=$row["username"];
        $r["password"]=$row["password"];
        $r["firstname"]=$row["firstname"];
        $r["lastname"]=$row["lastname"];
        $r["age"]=$row["age"];
    }
    $status="FOUND";//Notifying that we found the user
    $response=array('status'=>$status,'user'=>$r);//sending the flag and the user
    echo json_encode($response);//enconding to json and echoing the response
} else {
    $status="NOT_FOUND";//Notifying that we did not found the user
    $response=array('status'=>$status); //sending only the flag
    echo json_encode($response);//enconding to json and echoing the response
}
 close_database($connection);//closing the connection
}
?>
