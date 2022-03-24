<?php
function getDbConnection() {
    $dbHost = "localhost";
    $dbName = "test";
    $dbUser = "root";
    $dbPass = "1234";
    
    
    
    $dbLink = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
    if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit;
    }
    return $dbLink;
    }
?>
