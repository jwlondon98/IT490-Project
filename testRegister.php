#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("dbConn.ini","dbServer");

$request = array();
$request['type'] = "register";
$request['username'] = "TestUser";
$request['password'] = "12345";
$request['email'] = "testEmail@gmail.com";

$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;

?>
