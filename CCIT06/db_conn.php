<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db_lmt";


    try {

        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);   
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    } catch(PDOStatement $e) {
        echo "Connection Failed" .$exception->getMessage();
    }
?>