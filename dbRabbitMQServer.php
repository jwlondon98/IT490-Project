#! /usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

require_once('RabbitLogger/490Logger.php');

require_once('getDB.php');

function doRegister($email,$username,$password)
{
    $dbLogin = $GLOBALS['dbLogin']; //gets the registation database defined at the bottom of the file
    
    $password_hash = password_hash($password, PASSWORD_BCRYPT); //hashes the user password
    
    
    //array where all parameters to input into the SQL request go. 
    //Starting each with a : is not neccessary, but helps differentiate the SQL variables from the PHP ones
    $params = array();  
    $params[':email'] = $email;
    $params[':username'] = $username;
    $params[':password'] = $password_hash;
    
    
    //builds the SQL statement, the syntax should be exactly the same as what you are used to
    //Note how the values in the $params array are in the SQL statement
    $stmt = $dbLogin->prepare("INSERT INTO users(user_email, user_name, user_password_hash) VALUES(:email, :username, :password)");
    
    //executes the prepared statement, make sure to input the $params array, or else the call won't work
    $r = $stmt->execute($params);
    
    //$e gets populated with any SQL error info from the database
    $e = $stmt->errorInfo();
    
    if($e[0] == "00000") //error code for no errors
    {
        $message = "Registration successful";
        $success = true;
    }
    else if($e[0] == "23000") //error code for duplicate entry
    {
        $message = "User already exists, try another username";
        $success = false;
    }
    else //if we get another error we haven't accounted for
    {
        $message = "Something isn't working, try again later";
        $success = false;
    }
    
    //returns true if the registration worked, false otherwise, and a message saying what happened
    return array("success" => $success, "message" => $message);
}

function doLogin($username,$password)
{
    $dbLogin = $GLOBALS['dbLogin'];
    
    $login = false;
    $sessionToken;
    
    $params = array();
    $params[':username'] =  $username;
    
    //checks to see if a user exists with the provided username
    $stmt = $dbLogin->prepare("SELECT user_id, user_email, user_name, user_password_hash from users 
        WHERE user_name = :username LIMIT 1");
        
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    
    if($e[0] != "00000")
    {
        $logger->log_rabbit('Error', 'Database call returned error');
    }
    
    //gets the result of the SQL request, and populates them into $result as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    //checks to see if a password hash was returned
    if($result && isset($result["user_password_hash"]))
    {
        $password_hash_from_db = $result["user_password_hash"];
        
        //checks to see if the hashed version of the password the user gave is the same as the one from the database
        //TODO, make it so we hash the password BEFORE we send it via rabbit, this is a security issue
        if(password_verify($password, $password_hash_from_db))
        {
            //should create a new random session ID for the user
            $sessionToken = session_create_id();
            
            //gets the current unix timestamp for validation later
            $sessionTime = time();
            
            $login = true;
            
            $params = array();
            $params[':session_token'] = $sessionToken;
            $params[':session_time'] = $sessionTime;
            $params[':user_id'] = $result['user_id'];
            
            //updates the session token and session time so we can use them to validate the user sessions
            $stmt = $loginDB->prepare("UPDATE users SET session_token = :session_token, session_time = :session_time WHERE user_id = :user_id");
            
            $r = $stmt->execute($params);
            $e = $stmt->errorInfo();
            
            if($e[0] != "00000")
            {
                $logger->log_rabbit('Error', 'Session could not be set, try again later');
                $login = false;
            }
            
        }
        else
        {
            $login = false;
        }
    }
    else
    {
        $login = false;
    }
    


    //if the login is successful, returns true, plus the session token and session time to be applied to the user
    if($login)
    {
        return array("login" => $login, "sessionToken" => $sessionToken, "sessionTime" => $sessionTime);
    }
    else //just returns false, showing that the user is not logged in
    {
	    return array("login" => $login);
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
/*    
	$params = array();
	$params = [':username'] = $username;
	$params = [':lobbyID'] = $lobbyID;
	$params = [':message'] = $message;

	$stmt = $Game->prepare("INSERT INTO Chat(username, lobbyID, message) VALUES(:username, :lobbyID, :message)");
	
	$r = $stmt->execute($params);

	$e = $stmet->errorInfo();

	if($e[0] == "00000")
	{
		$message = "Chat Stored";
		$success = true;
	}
	else
	{
		$message = "Chat Failed";
		$success = false;
	}
 */
	//adds message to the chat database with the username and lobby ID
	//if possible, maybe delete chat records from lobbies that no longer exist or are too old
    //fill success variable as true or false if the chat was sent to the db
    
    $success;
    
    return array("success" => $success);
}

function getChat($lobbyID)
{
/*
	$params = array();
	$params = [':lobbyID'] = $lobbyID;

    //returns most recent chats (idk, maybe 10 most recent)
    //I'll let you decide what format these should be sent back as, maybe an
    //array of arrays, with each sub array having the username of the sender and the message
    
 */  
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
    case "register":
      return doRegister($request['email'],$request['username'],$request['password']);
      
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



$logger = new rabbitLogger("RabbitLogger/logger.ini", "testListener");
$server = new rabbitMQServer("dbConn.ini","dbServer");

$GLOBALS['dbGame'] = getDB("Game");
$GLOBALS['dbLogin'] = getDB("login");

if (!isset($dbGame) || !isset($dbLogin)) 
{
    $logger->log_rabbit('Error', 'Databases in dbServer not connected. Is the server up?');
    exit();
}

echo "Started db request server";
$logger->log_rabbit('Info', "Started db request server");

$server->process_requests('requestProcessor');
exit();
?>
