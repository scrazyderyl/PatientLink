<?php
    require "common.php";

    $sql = new mysqli("localhost", "root", "password", "pitt");
    if($sql->connect_error) {
        echo "Failed";
        die("Connection failed: " . $sql->connect_error);
    };
    
    $return =  json_encode(queryOnceGetData($sql, "SELECT name from test", null, null));
    echo $return;
    return $return;
?>