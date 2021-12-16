<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("dbConn.ini","dbServer");

$request = array();
$request['type'] = "setUserStats";


if(isset($_POST['id']))
{
    $request['user_id'] = $_POST['id'];
}
else
{
    $request['user_id'] = 0;
}
if(isset($_POST['played']))
{
    $request['gamesPlayed'] = $_POST['played'];
}
else
{
    $request['gamesPlayed'] = 100;
}
if(isset($_POST['won']))
{
    $request['gamesWon'] = $_POST['won'];
}
else
{
    $request['gamesWon'] = 100;
}
if(isset($_POST['words']))
{
    $request['wordsPlayed'] = $_POST['words'];
}
else
{
    $request['wordsPlayed'] = 100;
}

if(isset($_POST['responseList']))
{
    $wordList = array();
    $responseList = $_POST['responseList'];
    
    for($i = 0; $i < count($responseList); $i++)
    {
        
        if(array_key_exists($responseList[$i], $wordList))
        {
            $wordList[$responseList[$i]] = $wordList[$responseList[$i]] + 1;
        }
        else
        {
            $wordList[$responseList[$i]] = 1;
        }
    }

    $serialized = serialize($wordList);
    $request['wordList'] = $serialized;
}
else
{
    $request['wordList'] = "";
}

$response = $client->send_request($request);

var_dump($response);
//$response = $client->publish($request);

?>
