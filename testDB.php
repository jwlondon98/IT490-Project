#!/usr/bin/php
<?php

$servername = "192.168.194.228";
$username = "eric";
$password = "Whoop1234!";

$gameDBName = "Game";
$regDBName = "login";

try
{
	$conn_string = "mysql:host=$servername;dbname=$gameDBName;charset=utf8mb4";

	$conn = new PDO($conn_string, $username, $password);
	
	echo "Connected successfully";
}
catch(Exception $e)
{

	var_export($e);
	$conn = NULL;
}


?>
