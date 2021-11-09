#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("apiConn.ini","apiServer");

$request = array();
$request['type'] = "getQuote";
$request['username'] = "zt";
$request['password'] = "tryme";
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
var_dump($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;

