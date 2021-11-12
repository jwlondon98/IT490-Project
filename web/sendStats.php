<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("dbConn.ini","dbServer");

$request = array();
$request['type'] = "setUserStats";

if(isset($_SESSION['user_id']))
{
    $request['user_id'] = $_SESSION['user_id'];
}
if(isset($_POST['gamesPlayed']))
{
    $request['gamesPlayed'] = $_POST['gamesPlayed'];
}
if(isset($_POST['gamesWon']))
{
    $request['gamesWon'] = $_POST['gamesWon'];
}
if(isset($_POST['wordsPlayed']))
{
    $request['wordsPlayed'] = $_POST['wordsPlayed'];
}

$response = $client->send_request($request);
//$response = $client->publish($request);

?>
