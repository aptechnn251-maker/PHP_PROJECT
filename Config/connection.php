<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "onlineshop";

    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn){
        echo "connected failed";
    }
    
?>