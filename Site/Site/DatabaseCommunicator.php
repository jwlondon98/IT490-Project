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
    $request = array();
    $request['type'] = $_POST['type'];
    $request['email'] = $_POST['email'];
    $request['username'] = $_POST['username'];
    $request['password'] = $_POST['password'];
    
    $response = $client->send_request($request);
}

?>
