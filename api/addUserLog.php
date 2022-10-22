<?php
    require "common.php";
    $wData = $_POST['data'];
    $id = $_POST['id'];

    $sql = new mysqli("localhost", "root", "password", "pitt");
    if($sql->connect_error) {
        echo "Failed";
        die("Connection failed: " . $sql->connect_error);
    };
    $query = "UPDATE userLog SET data='".$wData."' WHERE id=".$id;
    
    queryOnceRun($sql, $query, null, null);
?>