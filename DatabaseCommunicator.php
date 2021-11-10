#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("dbConn.ini","dbServer");

// arg 1  |  request type
// arg 2  |  request count
// arg 3+ |  values 

if (isset($argc)) {
	// for ($i = 0; $i < $argc; $i++) {
	// 	echo "\n\nArgument #" . $i . " - " . $argv[$i] . "\n";
	// }

    // switch request type
    switch ($argv[1])
    {
        case "register":
            register();
            break;
    }
}


function register()
{
    // echo "[DBComm] Register";

    $request = array();
    $request['type'] = $argv[1];
    $request['email'] = $argv[3];
    $request['username'] = $argv[4];
    $request['password'] = $argv[5];
    
    $response = $client->send_request($request);
    //$response = $client->publish($request);
}

function requestStatus($response)
{
    echo "(RESPONSE-START " . $argv[2] . ")". ": " . $response['success'] . " (RESPONSE-END))";
}

?>
