#!/usr/bin/php
<?php

$mydb = new mysqli('127.0.0.1','root','12345','testdb');

if ($mydb->errno != 0)
{
	echo "failed to connect to database: ". $mydb->error . PHP_EOL;
	exit(0);
}

echo "successfully connected to database".PHP_EOL;

$query = "select * from students;";

$response = $mydb->query($query);
if ($mydb->errno != 0)
{
	echo "failed to execute query:".PHP_EOL;
	echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
	exit(0);
}


if ($response) {
  while ($row = $response -> fetch_row()) {
    printf ("%s %s %s %s\n", $row[0], $row[1], $row[2], $row[3]);
  }
  $result -> free_result();
}

mysqli_close($mydb);

?>
