<?php
require("../database.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$connection=init_database();
//print_r($_POST);
//die();
$data = json_decode(file_get_contents("php://input"));
$username = mysql_real_escape_string($data->username);
$password = mysql_real_escape_string($data->password);
$authenticated="PENDING";

$sql = "SELECT firstname, lastname FROM users WHERE username='$username' AND password='$password' ;";
$result = $connection->query($sql);
//echo "query: ".$sql;
if ($result->num_rows > 0) {
  //echo "FOUND something";
    $r=array();
    //print_r($result);

    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $r["username"]=$username;
        $r["firstname"]=$row["firstname"];
        $r["lastname"]=$row["lastname"];
    }
    $authenticated="FOUND";
    $response=array('authenticated'=>$authenticated,'user'=>$r);
    print json_encode($response);
} else {
    $authenticated="NOT FOUND";
    $response=array('authenticated'=>$authenticated);
    print json_encode($response);
}
 close_database($connection);
}
?>
