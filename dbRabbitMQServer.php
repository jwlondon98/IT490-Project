#!/usr/bin/php
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
    $logger = $GLOBALS['logger'];
    
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
            $sessionTime = time() + 180;
            
            $login = true;
            
            
            $params = array();
            $params[':session_token'] = $sessionToken;
            //$params[':session_time'] = $sessionTime;
            $params[':user_id'] = $result['user_id'];
            
            //updates the session token and session time so we can use them to validate the user sessions
            $stmt = $dbLogin->prepare("UPDATE users SET session_token = :session_token WHERE user_id = :user_id");
            
            echo "\npassword verified\n";
            $r = $stmt->execute($params);
            $e = $stmt->errorInfo();
            
            
            echo ("ERORR: " . $e[0]);
            
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
    	echo "login successful";
        return array("login" => $login, "sessionToken" => $sessionToken, "sessionTime" => $sessionTime, "userID" => $result['user_id']);
    }
    else //just returns false, showing that the user is not logged in
    {
    
    	echo "login failed";
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

function setUserStats($user_id, $gamesPlayed, $wordsPlayed, $gamesWon)
{
  $dbGame = $GLOBALS['dbGame'];

  $params = array();
  $params[':user_id'] = $user_id;
  $params[':gamesPlayed'] = $gamesPlayed;
  $params[':wordsPlayed'] = $wordsPlayed;
  $params[':gamesWon'] = $gamesWon;
  $selParams = array();
  $selParams[':user_id'] = $user_id;
  
  echo "\nSET STATS: " . $user_id .  "\n";
  echo "\nSET gamesPlayed: " . $gamesPlayed .  "\n";
  echo "\nSET wordsPlayed: " . $wordsPlayed .  "\n";
  echo "\nSET gamesWon: " . $gamesWon .  "\n";
  
  $selectStatement = $dbGame->prepare("SELECT * FROM userStats where user_id = :user_id");
  $result = $selectStatement->execute($selParams);
  $e = $selectStatement->errorInfo();
  
  if ($selectStatement->rowCount() == 0)
  {
   	$insertStatement = $dbGame->prepare("INSERT INTO userStats(user_id, gamesPlayed, wordsPlayed, gamesWon) VALUES(:user_id, :gamesPlayed, :wordsPlayed, :gamesWon)");
  	
  	$result = $insertStatement->execute($params);
  	$e = $insertStatement->errorInfo();
  }
  else
  {
  	$updateStatement = $dbGame->prepare("UPDATE userStats SET gamesPlayed = gamesPlayed+:gamesPlayed, gamesWon = gamesWon+:gamesWon, wordsPlayed = wordsPlayed+:wordsPlayed WHERE user_id = :user_id");
  	
  	$result = $updateStatement->execute($params);
  	$e = $updateStatement->errorInfo();
  }
  

  if($e[0] == "00000")
  {
    $message = "User Stats Set";
    $success = true;
  }
  else
  {
    $message = "No User Stats Set";
    $success = false;
  }
  
  

  return array("success" => $success);
}


function getUserStats($user_id)
{
  $dbGame = $GLOBALS['dbGame'];

  $params = array();
  $params[':user_id'] = $user_id;
 
  
  $stmt = $dbGame->prepare("SELECT gamesPlayed, wordsPlayed, gamesWon from userStats WHERE user_id = :user_id");

  $r = $stmt->execute($params);
  $e = $stmt->errorInfo();

  $stats = $stmt->fetch(PDO::FETCH_ASSOC);
  if($e[0] == "00000")
  {
    $message = "User Stats Retrieved";
    $success = true;
  }
  else
  {
    $message = "No User Stats Retrieved";
    $success = false;
  }
  	
	var_dump($stats);
  	
  return array("success" => $success, "message" => $message, "stats" => $stats);
}

function sendChat($user_id, $message)
{
    $dbGame = $GLOBALS['dbGame'];
    $params = array();
    $params[':user_id'] = $user_id;
    $params[':message'] = $message;

    $stmt = $dbGame->prepare("INSERT INTO Chat(user_id, message) VALUES(:user_id, :message)");

    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    
    if($e[0] == "00000")
    {
        $message = "Chat Saved";
        $success = true;
    }
    else
    {
        $message = "No Chat saved";
        $success = false;
    }

    return array("success" => $success);
}

function getChat()
{
    $dbGame = $GLOBALS['dbGame'];
    $params = array();
    //$params[':user_id'] = $user_id;
    //$params[':message'] = $message;

    $stmt = $dbGame->prepare("SELECT user_id, message from Chat");

//$stmt = $dbGame->prepare("SELECT user_id, message from Chat WHERE user_id = :user_id, message = :message");
    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    
    $chat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if($e[0] == "00000")
    {
        $message = "Chat Recieved";
        $success = true;
    }
    else
    {
        $message = "No Chat Received";
        $success = false;
    }

	echo "\nchat dump\n";
    var_dump($chat);

    return array("success" => $success, "chat" => $chat);
}

function setFriends($user_id, $friend_id)
{
    $dbGame = $GLOBALS['dbGame'];
    $params = array();
    $params[':user_id'] = $user_id;
    $params[':friend_id'] = $friend_id;
    $stmt = $dbGame->prepare("INSERT INTO Friends(user_id, friend_id) VALUES(:user_id, :friend_id)");

    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();
    if($e[0] == "00000")
    {
        $message = "Friends added";
        $success = true;
    }
    else
    {
        $message = "No Friends added";
        $success = false;
    }

    return array("setFriends" => $success);
}

function getFriends($user_id)
{
	$dbGame = $GLOBALS['dbGame'];
	$params = array();
	$params[':user_id'] = $user_id;
	echo "\nGET FRIENDS\n";
        echo "USER ID: " . $user_id;
        $stmt = $dbGame->prepare("SELECT friend_id from Friends WHERE user_id = :user_id");
        //$stmt = $dbGame->prepare("SELECT * from users");
        
        $r = $stmt->execute($params);
        $e = $stmt->errorInfo();
        
        $friends =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($e[0] == "00000")
        {
                $message = "Friends retrieved";
                $success = true;
        }
        else
        {
                $message = "No Friends retrieved";
                $success = false;
        }      
        
        var_dump($friends);
        return array("success" => $success, "friends" => $friends);  
}       

function getAchievements($user_id)
{
  $dbGame = $GLOBALS['dbGame'];

  $params = array();
  $params[':user_id'] = $user_id;
 
  
  $stmt = $dbGame->prepare("SELECT gamesPlayed, wordsPlayed, gamesWon, userWords from userStats WHERE user_id = :user_id");

  $r = $stmt->execute($params);
  $e = $stmt->errorInfo();

  $stats = $stmt->fetch(PDO::FETCH_ASSOC);
  if($e[0] == "00000")
  {
    $message = "User Stats Retrieved";
    $success = true;
  }
  else
  {
    $message = "No User Stats Retrieved";
    $success = false;
  }
  	
	$achievements = array();
	
	if($stats["gamesPlayed"] >= 100)
	{
        $achievements["play100"] = true;
        $achievements["play10"] = true;
        $achievements["play1"] = true;
	}
	else if($stats["gamesPlayed"] >= 10)
	{
        $achievements["play100"] = false;
        $achievements["play10"] = true;
        $achievements["play1"] = true;
	}
	else if($stats["gamesPlayed"] >= 1)
	{
        $achievements["play100"] = false;
        $achievements["play10"] = false;
        $achievements["play1"] = true;
	}
	else
	{
        $achievements["play100"] = false;
        $achievements["play10"] = false;
        $achievements["play1"] = false;
	}
	
	
	if($stats["gamesWon"] >= 100)
	{
        $achievements["win100"] = true;
        $achievements["win10"] = true;
        $achievements["win1"] = true;
	}
	else if($stats["gamesWon"] >= 10)
	{
        $achievements["win100"] = false;
        $achievements["win10"] = true;
        $achievements["win1"] = true;
	}
	else if($stats["gamesWon"] >= 1)
	{
        $achievements["win100"] = false;
        $achievements["win10"] = false;
        $achievements["win1"] = true;
	}
	else
	{
        $achievements["win100"] = false;
        $achievements["win10"] = false;
        $achievements["win1"] = false;
	}

	
    if($stats["wordsPlayed"] >= 500)
	{
        $achievements["words500"] = true;
        $achievements["words50"] = true;
	}
	else if($stats["wordsPlayed"] >= 50)
	{
        $achievements["words500"] = false;
        $achievements["words50"] = true;
	}
	else
	{
        $achievements["words500"] = false;
        $achievements["words50"] = false;
	}
	
	$wordList = unserialize($stats["userWords"]);
	
	arsort($wordList);
	$mostUsed = reset($wordList);
	
    if($mostUsed >= 100)
	{
        $achievements["oneword100"] = true;
        $achievements["oneword10"] = true;
	}
	else if($mostUsed >= 10)
	{
        $achievements["oneword100"] = false;
        $achievements["oneword10"] = true;
	}
	else
	{
        $achievements["oneword100"] = false;
        $achievements["oneword10"] = false;
	}
	
  	
  return array("success" => $success, "message" => $message, "achievements" => $achievements);
}

function getWordStats($user_id)
{
    $dbGame = $GLOBALS['dbGame'];

    $params = array();
    $params[':user_id'] = $user_id;
    
    
    $stmt = $dbGame->prepare("SELECT userWords from userStats WHERE user_id = :user_id");

    $r = $stmt->execute($params);
    $e = $stmt->errorInfo();

    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    if($e[0] == "00000")
    {
        $message = "User Stats Retrieved";
        $success = true;
    }
    else
    {
        $message = "No User Stats Retrieved";
        $success = false;
    }
  
    $wordList = unserialize($stats["userWords"]);
	
	arsort($wordList);
	
	$wordList = array_slice($wordList, 0, 10);
	
	return array("success" => $success, "message" => $message, "wordList" => $wordList);
	
	
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
      
      //update with words used
    case "setUserStats":
      return setUserStats($request['user_id'], $request['gamesPlayed'], $request['wordsPlayed'], $request['gamesWon']);
      
    case "getUserStats":
      return getUserStats($request['user_id']);
      
    case "sendChat":
      return sendChat($request['user_id'], $request['message']);
    
    case "getChat":
      return getChat();
      
    case "setFriends":
      return setFriends($request['user_id'], $request['friend_id']);
      
    case "getFriends":
      return getFriends($request['user_id']);
      
    case "getAchievements":
      return getAchievements($request['user_id']);
      
    case "getWordStats":
      return getWordStats($request['user_id']);
  }
  
  return array("returnCode" => '0', 'message'=>"request type not found");
}



$logger = new rabbitLogger("RabbitLogger/logger.ini", "testListener");
$server = new rabbitMQServer("dbConn.ini","dbServer");

$foundGame = true;
$foundLobby = true;

$GLOBALS['test'] = "Test";
$GLOBALS['logger'] = $logger;


$dbGame = getDB("Game");
$dbLogin = getDB("login");



if (!isset($dbGame)) 
{
    $logger->log_rabbit('Error', 'Game database in dbServer not connected. Is the server up?');
    echo 'Game database in dbServer not connected. Is the server up?'.PHP_EOL;
    $foundGame = false;
    
    //exit();
}
else
{
    $GLOBALS['dbGame'] = $dbGame;
}

if(!isset($dbLogin))
{
    $logger->log_rabbit('Error', 'Login database not working in dbServer not connected. Is the server up?');
    echo 'Login database in dbServer not connected. Is the server up?'.PHP_EOL;
    //exit();
    
    $foundLobby = false;
}
else
{
    $GLOBALS['dbLogin'] = $dbLogin;
}

if($foundLobby == false || $foundGame == false)
{
    exit();
}

echo "Started db request server";
$logger->log_rabbit('Info', "Started db request server");

$server->process_requests('requestProcessor');
exit();
?>
