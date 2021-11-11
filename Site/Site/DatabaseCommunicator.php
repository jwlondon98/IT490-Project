<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

echo "DBComm says hi";

$client = new rabbitMQClient("dbConn.ini","dbServer");

// arg 1  |  request type
// arg 2+ |  values 

if (isset($_POST['type'])) 
{
    // switch request type
    switch ($_POST['type'])
    {
        case "register":
            register();
            break;
    }
}


function register()
{
    Log("register called");
    $request = array();
    $request['type'] = $_POST['type'];
    $request['email'] = $_POST['email'];
    $request['username'] = $_POST['username'];
    $request['password'] = $_POST['password'];
    
    $response = $client->send_request($request);

    sendResponse($response['response']);

    Log("register end");
}

function sendResponse($resp)
{
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $resp);

    curl_exec($ch);
}

function Log($msg)
{
    echo "<script>console.log('Debug Objects: " . msg . "' );</script>";
}

?>
