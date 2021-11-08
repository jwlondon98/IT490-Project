#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
    // lookup username in databas
    // check password


    //set login equal to true or false if login is successful or not
    $login;

    //set sessionToken equal to a session token to make sure the user is logged in
    $sessionToken

    if($login)
    {
        return array("response" => $login, "sessionToken" => $sessionToken);
    }
    else
    {
	    return array("response" => $login);
    }
}

function doValidate($sessionID)
{
    //check DB to see if the current session time is expired for the session ID
    //also check to see if sessionID is valid for any user
    //set expired equal to true of false if session is expired and user needs to login again
    $expired;
    
    return array("response" => $expired);
}

function getLobbies($gameMode)
{
   //returns list of all lobbies in the database with the provided gamemode
   //also deletes all lobbies where the lobby was created at least 5 minutes ago
   //and the number of players = 0
   
   //fill lobby list with the lobby ids of each lobby that fits the gamemode
   
   $lobbyList = array();
   
   return array("lobbyList" => $lobbyList);

}

function joinLobby($username, $lobbyID)
{
    //adds a player to the list of players in a lobby in the DB
    //fill value of didJoin to true on a successful join, false otherwise
    
    $didJoin;
    
    return array("didJoin" => $didJoin);
}

function leaveLobby($username, $lobbyID)
{
    //deletes a player to the list of players in a lobby in the DB
    //fill value of didJoin to true on a successful leave, false otherwise
    
    $didLeave;
    
    return array("didLeave" => $didLeave);
}

function setUserStats($username, $gamesPlayed, $wordsFilled, $roundsWon)
{
    //adds the provided stats to the user in the stats table
    //fills success with true or false depending on if it worked
    
    $success;
    
    return array("success" => $success);
}

function getUserStats($username)
{
    //fills user stat values from DB

    
    $gamesPlayed;
    $wordsFilled;
    $roundsWon;
    
    return array("gamesPlayed" => $gamesPlayed, "wordsFilled" => $wordsFilled, "roundsWon" => $roundsWon);
}

function sendChat($username, $lobbyID, $message)
{
    //adds message to the chat database with the username and lobby ID
    //if possible, maybe delete chat records from lobbies that no longer exist or are too old
    //fill success variable as true or false if the chat was sent to the db
    
    $success;
    
    return array("success" => $success);
}

function getChat($lobbyID)
{
    //returns most recent chats (idk, maybe 10 most recent)
    //I'll let you decide what format these should be sent back as, maybe an
    //array of arrays, with each sub array having the username of the sender and the message
    
    
}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
      
    case "validate_session":
      return doValidate($request['sessionId']);
      
    case "getLobbies":
      return getLobbies($request['gamemode']);
      
    case "joinLobby":
      return joinLobby($request['username'], $request['lobbyID']);
      
    case "leaveLobby":
      return leaveLobby($request['username'], $request['lobbyID']);
      
    case "setUserStats":
      return setUserStats($request['username'], $request['gamesPlayed'], $request['wordsFilled'], $request['roundsWon']);
      
    case "getUserStats":
      return getUserStats($request['username']);
      
    case "sendChat":
      return sendChat($request['username'], $request['lobbyID'], $request['message']);
    
    case "getChat":
      return getChat($request['lobbyID']);
  }
  
  return array("returnCode" => '0', 'message'=>"request type not found");
}

$server = new rabbitMQServer("dbConn.ini","dbServer");

$server->process_requests('requestProcessor');
exit();
?>

