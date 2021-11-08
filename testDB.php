#!/usr/bin/php
<?php

$servername = "192.168.194.228";
$username = "eric";
$password = "Whoop1234!";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error) {
	die("Connection fialed: ".$conn->connect_error);
}

echo "Connected successfully";

?>
