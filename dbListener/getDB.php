#!/usr/bin/php
<?php

function getDB($dbName)
{
    
    $servername = "localhost";
    $username = "eric";
    $password = "Whoop1234!";

    $gameDBName = "Game";
    $regDBName = "login";


    if($dbName != "Game" && $dbName != "login")
    {
        echo "Db name not recognized";
        return NULL;
    }
    
    try
    {
        $conn_string = "mysql:host=$servername;dbname=$dbName;charset=utf8mb4";

        $conn = new PDO($conn_string, $username, $password);

        return $conn;
    }
    catch(Exception $e)
    {

        var_export($e);
        $conn = NULL;
    }
}

?>
