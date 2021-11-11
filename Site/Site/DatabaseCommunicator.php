<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

echo "DBComm says hi\n\n";


// arg 1  |  request type
// arg 2+ |  values 

$client = new rabbitMQClient("dbConn.ini","dbServer");
testRegister($client);

if (isset($_POST['type'])) 
{
    
    // switch request type
    switch ($_POST['type'])
    {
        case "register":
            register($client);
            break;
    }
}

function testRegister($client)
{
    Out("register called\n");
    $request = array();
    $request['type'] = "register";
    $request['email'] = "testPoo@gmail.com";
    $request['username'] = "testPooUser";
    $request['password'] = "testPooPass";
    
    $response = $client->send_request($request);
    Out("test\n");
    if (isset($response['response']))
    {
        Out("register response\n" . $response['response']);        
        sendResponse($response['response']);

    }

    Out("register end");
}

function register($client)
{
    Out("register called");
    $request = array();
    $request['type'] = $_POST['type'];
    $request['email'] = $_POST['email'];
    $request['username'] = $_POST['username'];
    $request['password'] = $_POST['password'];
    
    $response = $client->send_request($request);

    sendResponse($response['response']);

    Out("register end");
}

function sendResponse($resp)
{
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $resp);

    curl_exec($ch);
}

function Out($msg)
{
    // echo "<script>console.log('Debug Objects: " . msg . "' );</script>";
    echo $msg . "\n";
}

?>
