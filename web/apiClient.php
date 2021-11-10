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

$i = 0;

for($i; $i < count($response); $i++)
{
    echo $response[$i];
    echo " ";
}

?>
