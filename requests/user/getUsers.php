<?php

require("../database.php"); //Importing the Database.php to get our connection to the database



if ($_SERVER['REQUEST_METHOD'] === 'POST') {//checking that the request comes from a POST method
    $connection = init_database(); //getting the connection from database.php
    /*
      Since we are using angular js and because of the header that this framework
      produces when using its object $https we can't use the native object $_POST.

      mysql_real_escape_string - is used to avoid at an initial phase sql injections.

     */
    $data = json_decode(file_get_contents("php://input")); //We use this line of code because $_POST comes empty
    $id = mysql_real_escape_string($data->id); //Getting the id value
    $page = mysql_real_escape_string($data->page); //Getting the id value
    $sql = "SELECT * FROM  users u"
            . " WHERE u.id!=$id "
            . " AND u.id NOT IN (SELECT uf.users_b FROM users_has_friends uf WHERE uf.users_a=$id)"
            . " AND u.id NOT IN (SELECT uf.users_a FROM users_has_friends uf WHERE uf.users_b=$id);"; //Query
    $result = $connection->query($sql); //executing query
    $total = $result->num_rows;
    if ($page == 0) {
        if ($total > 10) {
            $sql = "SELECT * FROM  users u"
                    . " WHERE u.id!=$id "
                    . " AND u.id NOT IN (SELECT uf.users_b FROM users_has_friends uf WHERE uf.users_a=$id)"
                    . " AND u.id NOT IN (SELECT uf.users_a FROM users_has_friends uf WHERE uf.users_b=$id)"
                    . " ORDER BY u.username LIMIT 10 ;"; //Query
            $result = $connection->query($sql); //executing query
        }
//echo "query: ".$sql;
    } else {
        $page = 10 * ($page - 1);
        $sql = "SELECT * FROM  users u"
                . " WHERE u.id!=$id "
                . " AND u.id NOT IN (SELECT uf.users_b FROM users_has_friends uf WHERE uf.users_a=$id)"
                . " AND u.id NOT IN (SELECT uf.users_a FROM users_has_friends uf WHERE uf.users_b=$id)"
                . " ORDER BY u.username LIMIT $page, 10;"; //Query
        $result = $connection->query($sql); //executing query
        //$total = $result->num_rows;
    }
    $users = array();
    if ($result->num_rows > 0) {//if founds at least one row it goes inside the if
        while ($row = $result->fetch_assoc()) {
            $r = array();
            $r["id"] = $row["id"];
            $r["username"] = $row["username"];
//        $r["password"]=$row["password"];
            $r["firstname"] = $row["firstname"];
            $r["lastname"] = $row["lastname"];
//        $r["age"]=$row["age"];
            array_push($users, $r);
        }
        $pages = ceil($total / 10);
        $p = array();
        for ($i = 1; $i <= $pages; $i++) {
            array_push($p, $i);
        }
        $status = "FOUND"; //Notifying that we found the user
        $response = array('status' => $status, 'users' => $users, 'count' => $total, 'pages' => $p); //sending the flag and the user
        echo json_encode($response); //enconding to json and echoing the response
    } else {
        $status = "NOT_FOUND"; //Notifying that we did not found the user
        $response = array('status' => $status); //sending only the flag
        echo json_encode($response); //enconding to json and echoing the response
    }
    close_database($connection); //closing the connection
}
?>
