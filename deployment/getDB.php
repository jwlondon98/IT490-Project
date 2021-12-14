#!/usr/bin/php
<?php

function getDB()
{
    
    $servername = "localhost";
    $username = "deployment";
    $password = "IT490123";

    $dbName = "deployment";
    
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
