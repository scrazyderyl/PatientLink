<?php
    require "common.php";
    $id = $_POST['id'];

    $sql = new mysqli("localhost", "root", "password", "pitt");
    if($sql->connect_error) {
        echo "Failed";
        die("Connection failed: " . $sql->connect_error);
    };
    $query = "SELECT * FROM userMeds WHERE id=".$id;
    
    
    $return =  json_encode(queryOnceGetData($sql, $query, null, null));
    echo $return;
    return $return;
?>